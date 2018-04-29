/**
 * Greedy.java
 * 
 * This is the greedy solution to the matrix problem.
 * Note this solution will not always produce the optimal solution
 * to the matrix problem.
 * [Evan Wang & Branaugh Mackay]
 */ 

import java.awt.*;
import java.awt.event.*;
import javax.swing.*;

public class Greedy implements ActionListener
{
	private MatrixPanel elements; // the panel for the squares
	private ControlPanel controls; // the panel for the control buttons

	/**
	 * The greedy solution to the matrix problem.
	 *
	 * @param elements the GUI for the squares.
	 * @param controls the GUI for the control buttons.
	 */
	public Greedy(MatrixPanel elements, ControlPanel controls) {
		this.elements = elements;
		this.controls = controls;
	}

	/**
	 * Determine the mininum value between squares 'begin' and 'end'
	 * for the specified 'column'.
	 * 
	 * @param begin the index where to begin searching.
	 * @param end the index where to end searching.
	 * @param column the column to be searched.
	 *
	 * @return the index of the minimum value for the specified column
	 */
	public int minimum(int begin, int end, int column) {
		if (elements.valueOf(begin,column) < elements.valueOf(end,column))
			return begin;
		else
			return end;
	}

	/**
	 * Determine the index of the mininum value between squares 'index' and 
	 * 'index + 1' and 'index - 1' for the specified 'column'.
	 *
	 * @param index the index of the minimum value to be searched.
	 * @param column the column to be searched.
	 * 
	 * @return int the index of the minimum value for the specified column
	 */
	public int minimum(int index, int column) {
		int minimumIndex = index - 1;
		if (elements.valueOf(index,column) < elements.valueOf(minimumIndex,column))
			minimumIndex = index;
		if (elements.valueOf(index+1,column) < elements.valueOf(minimumIndex,column))
			minimumIndex = index + 1;

		return minimumIndex;
	}



	/**
	 * This will only be called when the "Greedy"
	 * button is clicked.
	 *
	 * This is an implementation of the greedy algorithm
	 * for the matrix problem. 
	 */
	public void actionPerformed(ActionEvent evt) {
		/**
		 * the cost of this algorithm.
		 */
		int totalCost = 0;

		/**
		 * index represents the index of the lowest
		 * valued square for a given column.
		 */
		int index = 0;

		/**
		 * determine the index of the smallest square
		 * at the leftmost column.
		 */
		int smallest = elements.valueOf(0,0);

		System.out.println(MatrixPanel.SIZE);
		for (int i = 1; i < MatrixPanel.SIZE; i++) { //Find min element in first column
			if (elements.valueOf(i,0) < smallest) {
				smallest = elements.valueOf(i,0);
				index = i;
			}
		}

		totalCost = smallest;//Cost of path

		// highlight the square 
		elements.setValues(index, 0, Color.blue);

		for (int j = 1; j < MatrixPanel.SIZE; j++) {//Follow the path through the columns until it reaches the end of the grid.
			
			if (index == 0) {//If at the top don't check the square diagonally above because it will be out of bounds
				int one = elements.valueOf(index,j);
				int two = elements.valueOf(index+1,j);
				if (one <= two) {
					smallest = one;
				}
				else {
					smallest = two;
					index = index+1;
				}
			}

			else if (index == 5) {//Same thing for the bottom row
				int one = elements.valueOf(index-1,j);
				int two = elements.valueOf(index,j);
				if (one <= two) {
					smallest = one;
					index = index-1;
				}
				else {
					smallest = two;
				}
			}

			else { //Otherwise check all three previous adjacent tiles
				int one = elements.valueOf(index-1,j);
				System.out.println(index-1 + " " + one);
				int two = elements.valueOf(index,j);
				System.out.println(index + " " + two);
				int three = elements.valueOf(index+1,j);
				System.out.println(index+1 + " " + three);
				if (one <= two) {
					if (one <= three) {
						smallest = one;
						index = index-1;
					}
					else {
						smallest = three;
						index = index+1;
					}
				}
				if (two < one) {
					if (two <= three) {
						smallest = two;
					}
					else {
						smallest = three;
						index=index+1;
					}
				}
			}
			totalCost = totalCost+smallest;
			elements.setValues(index, j, Color.blue);
		}


		/**
		 * We are done. Now update the output for total cost.
		 */
		controls.setTotal(totalCost);
	}
}
