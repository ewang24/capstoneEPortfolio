/**
 * TheMatrix.java
 *
 * This program solves the matrix move problem.
 * It provides two different algorithms:
 * Greedy - which is not optimal
 * Dynamic - which is optimal
 */

import javax.swing.*;
import java.awt.*;
import java.awt.event.*;

public class TheMatrix extends JFrame
{
  public TheMatrix() {
    setSize(500,500);
    MatrixPanel matrixPanel = new MatrixPanel();
    ControlPanel controlPanel = new ControlPanel(matrixPanel);
    getContentPane().add(controlPanel, "South");
    getContentPane().add(matrixPanel, "Center");
    this.setDefaultCloseOperation(DO_NOTHING_ON_CLOSE);
    
    /**
     * This allows the window to close 
     */
    this.addWindowListener(new WindowAdapter() 
	{
	    @Override
	    public void windowClosing(WindowEvent windowEvent) 
	    {
	    	
	    	  int confirm = JOptionPane.showConfirmDialog(null, "Do you really want to exit the program?", "Exit?", JOptionPane.YES_NO_OPTION);
	          if (confirm == JOptionPane.YES_OPTION) 
	          {
	        	  System.exit(0);
	          }
	          else
	          {
	          
	        	  return;
	          }
	          		    	
	    }
	});
  }
  
  public static void main(String[] args) {
	  try
		{
		UIManager.setLookAndFeel(UIManager.getSystemLookAndFeelClassName());
		}
		catch(Exception e)
		{
			
		}
    JFrame frame = new TheMatrix();
    frame.setTitle("Greedy & Dynamic Algorithm Path Finder");
    frame.setMinimumSize(new Dimension(500,500));
    //frame.show();
    frame.setVisible(true);
  }
} 
