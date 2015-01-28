import java.util.ArrayList;
import java.util.Collections;
import java.util.LinkedList;
import java.util.Queue;
import java.util.Stack;


public class Solver {
	int step = 0;
	ArrayList<Integer> states = new ArrayList<Integer>();
	
	int ArrayToInteger(int[][] input){
		String temp="";
		for(int i=0;i<3;i++){
			for(int j=0;j<3;j++){
				if(!(input[i][j] == 0 && i==0 && j==0)){
					temp += Integer.toString(input[i][j]);
				}
			}
		}
		
		return Integer.parseInt(temp);
	}
	
	boolean checkRepeated(Board input,int direction){
		int[][] copy = new int[3][3];
		for(int i =0;i<3;i++){
			for(int j = 0;j<3;j++){
				copy[i][j] = input.numbers[i][j];
			}
		}
		int x = input.xPos;
		int y = input.yPos;
		int temp;
		switch(direction){
		case 0 :
			temp = copy[y][x-1];
			copy[y][x-1] = 0;
			copy[y][x] = temp;
			break;
		case 1:
			temp = copy[y][x+1];
			copy[y][x+1] = 0;
			copy[y][x] = temp;
			break;
		case 2:
			temp = copy[y-1][x];
			copy[y-1][x] = 0;
			copy[y][x] = temp;
			break;
		case 3:
			temp = copy[y+1][x];
			copy[y+1][x] = 0;
			copy[y][x] = temp;
			break;
		default:
			break;
	}
		temp = ArrayToInteger(copy);
		if(Collections.binarySearch(states, temp) >=0){
			return true;
		}
		states.add(temp);
		states.sort(null);
		return false;
	}
	void BFS(Board board){
		long duration = System.currentTimeMillis();
		step = 0;
		states = new ArrayList<Integer>();
		Queue<Board> queue = new LinkedList<Board>();
		queue.offer(board);
		while(!queue.isEmpty()){
			step++;
			Board node = new Board(queue.remove());
			//System.out.println("step: " + step);
			//node.printNumber();
			if(node.isAnswer()){
				duration = System.currentTimeMillis() - duration;
				System.out.println("Correct,BFS uses " + step + " moves!"+"Answer's depth :" + node.depth + "It takes "+duration+ " ms!");
				break;
				
			}
			for(int i=0;i<4;i++){
				if(node.isValid(i)){
					if(!checkRepeated(node,i)){
						//System.out.println(i);
						Board child = new Board(node);
						child.changeNumber(i);
						child.incDepth();
						//child.printNumber();
						queue.add(child);
						//System.out.println("size: " + queue.size());
						
					}
				}
			}
		}
	}
	
	void IDS(Board board){
		long duration = System.currentTimeMillis();
		step = 0;
		int depth = 1;
		//DLS(board,26);
		while(true){
			if(!DLS(board,depth))
				break;
			depth++;
		}
		duration = System.currentTimeMillis() - duration;
		System.out.println("Correct,IDS uses " + step + " moves with depth " + depth +"!" + "It takes "+duration+ " ms!");
	}
	boolean DLS(Board board,int depth){
		Stack<Board> stack = new Stack<Board>();
		states = new ArrayList<Integer>();
		stack.push(board);
		while(!stack.isEmpty()){
			step++;
			Board node = new Board(stack.pop());
			//System.out.println("step: " + step);
			//System.out.println("node depth: " + node.depth);
			//node.printNumber();
			if(node.isAnswer())
				return false;
			for(int i=3;i>=0;i--){// it implies the four direction of movement,left,right,up,down
				if(node.isValid(i) && node.depth < depth){//isValid check if the movement is valid
					if(!node.repeatedAlongPath(i)){//check if the generated successor of node is already discovered
						Board child = new Board(node);//duplicate the node
						child.changeNumber(i);//perform the movement
						child.incDepth();//increase its depth by one
						stack.push(child);
					
					}
				}
			}
		}
		return true;
	}

	
	void AStar(Board board,int mode){
		long duration = System.currentTimeMillis();
		ArrayList<Board> openSet = new ArrayList<Board>();
		ArrayList<Board> closeSet = new ArrayList<Board>();
		openSet.add(board);
		step = 0;
		while(!openSet.isEmpty() ){
			step++;
			openSet.sort(null);
			closeSet.sort(null);
			Board node = new Board(openSet.remove(0));
			//System.out.println("step: " + step);
			//System.out.println("node depth: " + node.gScore);
			//node.printNumber();
			if(node.isAnswer()){
				duration = System.currentTimeMillis() - duration;
				switch(mode){
				case 0:
					System.out.println("Correct,A* with misplaced tiles uses " + step + " moves!Solution is at depth "+ node.gScore + "! It takes "+duration+ " ms!");
					break;
					
				case 1:
					System.out.println("Correct,A* with manhattan distance uses " + step + " moves!Solution is at depth "+ node.gScore + "! It takes "+duration+ " ms!");
					break;
					default:
				}
				break;
			}
			closeSet.add(node);
			for(int i=0;i<4;i++){
				if(node.isValid(i)){
					Board child = new Board(node);
					child.changeNumber(i);
					//System.out.println("child depth: " + child.gScore);
					int score = node.gScore;
					score++;
					child.calFScore(mode, score);
					int openSetPos = openSet.indexOf(child);
					int closeSetPos = closeSet.indexOf(child);
					//System.out.println("openSetPos: " + openSetPos+" closeSetPos: " + closeSetPos);
					if(openSetPos >=0){
						Board temp = openSet.get(openSet.indexOf(child));
						if(temp.gScore > child.gScore){
							temp.calFScore(mode, child.gScore);
						}
						continue;
					}
					if(closeSetPos>=0){
						Board temp = closeSet.get(closeSet.indexOf(child));
						if(temp.gScore > child.gScore){
							temp.calFScore(mode, child.gScore);
						}else
							continue;
					}
					openSet.add(child);
				}
			}
		}
		
	}

	
	public static void main(String[] args) {
		// TODO Auto-generated method stub
		Solver solver = new Solver();
		Board board = new Board();
		solver.BFS(board);
		solver.IDS(board);
		solver.AStar(board, 0);
		solver.AStar(board, 1);
			
	}

}
