/**
 * Input file contains logical addresses
 * Backing Store represents the file being read from disk (the 
 */

#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>

// number of characters to read for each line from input file
#define BUFFER_SIZE        10 

// number of bytes to read
#define CHUNK              256 

FILE    *address_file;
FILE    *backing_store;

// how we store reads from input file
char    address[BUFFER_SIZE];

int     logical_address;

// the buffer containing reads from backing store
signed char     buffer[CHUNK];

// the value of the byte (signed char) in memory
signed char     value;

//Pointer representing physical memory
char *physical_memory;

//Array to represent the page table. The position in the array represents the page  number and the value at that position represents the frame number. If the value is -1, the page is not in memory.
int page_table[CHUNK];


//Arrays to represent the TLB with frame number and page number.
int tlb_page[16];
int tlb_frame[16];

int tlb_hitrate=0;
int page_fault_rate = 0;

int main(int argc, char *argv[])
{
int tlb_fifo = 0;


int currentFrame = 0;

//Initialize tlb
for(int i = 0; i < 16; i ++)
{
	tlb_page[i]=-1;
}

//Initialize page table
for(int i = 0; i < CHUNK; i++)
{
 page_table[i]=-1;
}

//Initialize physical memory
physical_memory = (char*) malloc(32768);



    // perform basic error checking
    if (argc != 3) {
        fprintf(stderr,"Usage: ./vm [backing store] [input file]\n");
        return -1;
    }

    // open the file containing the backing store
    backing_store = fopen(argv[1], "rb");
    
    if (backing_store == NULL) { 
        fprintf(stderr, "Error opening %s\n",argv[1]);
        return -1;
    }

    // open the file containing the logical addresses
    address_file = fopen(argv[2], "r");


    if (address_file == NULL) {
        fprintf(stderr, "Error opening %s\n",argv[2]);
        return -1;
    }


	int fifo_wrap_physical=0;

	int total = 0;
    // read through the input file and output each logical address
    while ( fgets(address, BUFFER_SIZE, address_file) != NULL) {
	
     //total number of addresses read
   total++;

	logical_address = atoi(address);        
       
	//Extract page number and offset
	int pageNumber = (logical_address & 0x0000FF00)>>8;
	int offSet = (logical_address & 0x000000FF);	

        printf("Logical address: %d \t",logical_address);
	
	int tlbHit = 0;
	int frame = -1;

	//Check if the address is in the TLB
	for(int i = 0; i < 16; i ++)
	{
		if(tlb_page[i]==pageNumber)
		{
			tlbHit =1;
			frame = i;
			break;
		}
	}

	//If in TLB
	if(tlbHit == 1)
	{
		tlb_hitrate++;
		value = *(physical_memory+(tlb_frame[frame]*CHUNK)+offSet);	
	}
	else{

	//On TLB miss, check if address is in page_table
	if(page_table[pageNumber]==-1)//Page fault. Go to backing store.
	{	
		page_fault_rate++;

		//go to back store frame
	       if (fseek(backing_store, (CHUNK * pageNumber), SEEK_SET) != 0) {
        	    fprintf(stderr, "Error seeking in backing store\n");
           	return -1;
       		}

		
		//Load data from backing store
      		if (fread(buffer, sizeof(signed char), CHUNK, backing_store) == 0) {
           		 fprintf(stderr, "Error reading from backing store\n");
           		 return -1;
       		}
	

		//Check for page replacement
		if(fifo_wrap_physical==1)//Page replacement necessary
		{	
			//printf("page replace");
			int toReplace = currentFrame;
			for(int k = 0; k < CHUNK; k++)
			{
				
				if(page_table[k]==toReplace && k!=toReplace)
				{
					page_table[k]=-1;
					break;
				}	

			}
			page_table[pageNumber]=currentFrame;
		
			
			//Load the page we want into physical memory
			for(int i = 0; i < CHUNK; i ++)
			{

			*(physical_memory+(CHUNK*currentFrame)+i)=buffer[i];

			}
			
			tlb_frame[tlb_fifo]=currentFrame;	
			currentFrame = (currentFrame+1)%128;
	
		}	
		else//Page replacement unnecessary
		{
			//Update frame reference in page table as well as TLB
			page_table[pageNumber]=currentFrame;
			tlb_frame[tlb_fifo]=currentFrame;

			//Load the page we want into physical memory
			for(int i = 0; i < CHUNK; i ++)
			{

			*(physical_memory+(CHUNK*currentFrame)+i)=buffer[i];

			}

			currentFrame++;

			//Check if physical memory has filled up
			if(currentFrame == 128)
			{
				fifo_wrap_physical = 1;
			}
			currentFrame = currentFrame%128;
		}

		value = buffer[offSet];
	
		
	}
	else//No pagefault. Get frame from page table and load data.
	{
		tlb_frame[tlb_fifo]=page_table[pageNumber];

		value = *(physical_memory+(CHUNK*page_table[pageNumber])+offSet);
	}

		
	//Update TLB
	tlb_page[tlb_fifo]=pageNumber;
	tlb_fifo=(tlb_fifo+1)%16;

}
	printf("Physical address: %d\t",CHUNK*page_table[pageNumber]+offSet);
	printf("Value: %d \n",value);
	
    }


printf("Num Adresses read: %d\nTLB hit rate: %f\nPage fault rate: %f\n",total,tlb_hitrate/(1000.f),page_fault_rate/(1000.f));

    fclose(address_file);
    fclose(backing_store);

    return 0;
}
