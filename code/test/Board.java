import java.util.ArrayList;
import java.util.Collections;


public class Board implements Comparable<Board>{
	int[][] numbers = {  {7,2,4} , {5,0,6} , {8,3,1} } ;
	//int[][] numbers = {  {1,0,2} , {3,4,5} , {6,7,8} } ;
	int[][] answer =  {  {0,1,2} , {3,4,5} , {6,7,8} } ;
	ArrayList<Integer> path = new ArrayList<Integer>();
	int xPos = 1;
	int yPos = 1;
	int depth = 0;
	int fScore = 0;
	int gScore = 0;
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
	public boolean repeatedAlongPath(int direction){
		int[][] copy = new int[3][3];
		for(int i =0;i<3;i++){
			for(int j = 0;j<3;j++){
				copy[i][j] = this.numbers[i][j];
			}
		}
		int x = this.xPos;
		int y = this.yPos;
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
		if(Collections.binarySearch(this.path, temp) >=0){
			return true;
		}
		return false;
		
	}
	public boolean isAnswer(){
		if(numbers[0][0] == 0 && numbers[0][1] == 1 && numbers[0][2] == 2
				&& numbers[1][0] == 3 && numbers[1][1] == 4 && numbers[1][2] == 5
				 && numbers[2][0] == 6 && numbers[2][1] == 7 && numbers[2][2] == 8)
			return true;
		else
			return false;
	}
	public void incDepth(){
		this.depth = this.depth + 1;
		
	}
	public void printNumber(){
		for(int i = 0;i<3;i++){
			String temp = "";
			for(int j = 0;j<3;j++){
				temp += numbers[i][j] + " ";
			}
			System.out.println(temp);
		}
	}
	public void misplacedTiles(){
		int num = 0;
		for(int i = 0;i<3;i++){
			for(int j = 0;j<3;j++){
				if(numbers[i][j] != answer[i][j] && numbers[i][j] != 0)
					num++;
			}
			}
		this.fScore += num;
		
	}
	public void calFScore(int mode,int g){
		this.fScore = g;
		this.gScore = g;
		//System.out.println("fscore : "+ this.fScore + " gscore : " + this.gScore);
		switch(mode){
		case 0:
			//MisplacedTiles
			this.misplacedTiles();
			break;
		case 1:
			this.ManhattanDistance();
			break;
		default:
		}
		//System.out.println("fscore : "+ this.fScore + " gscore : " + this.gScore);
		
	}
	public void ManhattanDistance(){
		int distance = 0;
		for(int i = 0;i<3;i++){
			for(int j = 0;j<3;j++){
				switch(numbers[i][j]){
				case 0:
					distance += Math.abs(i-0);
					distance += Math.abs(j-0);
					break;
				case 1:
					distance += Math.abs(i-0);
					distance += Math.abs(j-1);
					break;
				case 2:
					distance += Math.abs(i-0);
					distance += Math.abs(j-2);
					break;
				case 3:
					distance += Math.abs(i-1);
					distance += Math.abs(j-0);
					break;
				case 4:
					distance += Math.abs(i-1);
					distance += Math.abs(j-1);
					break;
				case 5:
					distance += Math.abs(i-1);
					distance += Math.abs(j-2);
					break;
				case 6:
					distance += Math.abs(i-2);
					distance += Math.abs(j-0);
					break;
				case 7:
					distance += Math.abs(i-2);
					distance += Math.abs(j-1);
					break;
				case 8:
					distance += Math.abs(i-2);
					distance += Math.abs(j-2);
					break;
				default:
					break;
				}
			}
		}
		this.fScore +=  distance;
		
	}
	public void changeNumber(int direction){
		//left,right,up,down
		if(isValid(direction)){
			int temp;
			switch(direction){
			case 0 :
				temp = numbers[yPos][xPos-1];
				numbers[yPos][xPos-1] = 0;
				numbers[yPos][xPos] = temp;
				xPos -= 1;
				//System.out.println("case 0 end");
				break;
			case 1:
				temp = numbers[yPos][xPos+1];
				numbers[yPos][xPos+1] = 0;
				numbers[yPos][xPos] = temp;
				//System.out.println("case 1 end");
				xPos += 1;
				break;
			case 2:
				temp = numbers[yPos-1][xPos];
				numbers[yPos-1][xPos] = 0;
				numbers[yPos][xPos] = temp;
				//System.out.println("case 2 end");
				yPos -= 1;
				break;
			case 3:
				temp = numbers[yPos+1][xPos];
				numbers[yPos+1][xPos] = 0;
				numbers[yPos][xPos] = temp;
				//System.out.println("case 3 end");
				yPos += 1;
				break;
			default:
			}
		}
	}
	public boolean isValid(int direction){
		//left,right,up,down
		switch(direction){
		case 0 :
			if(xPos > 0)
				return true;
			else
				return false;
		case 1:
			if(xPos < 2)
				return true;
			else
				return false;
		case 2:
			if(yPos > 0)
				return true;
			else
				return false;
		case 3:
			if(yPos < 2)
				return true;
			else
				return false;
		default:
			return false;
		}
	}
	public Board(){
	}
	public Board(Board parent){
		for(int i =0;i<3;i++){
			for(int j = 0;j<3;j++){
				this.numbers[i][j] = parent.numbers[i][j];
			}
		}
		this.xPos = parent.xPos;
		this.yPos = parent.yPos;
		this.depth = parent.depth;
		this.fScore = parent.gScore;
		this.gScore = parent.gScore;
		this.path = new ArrayList<Integer>(parent.path);
		this.path.add(ArrayToInteger(this.numbers));
		Collections.sort(this.path);
		//this.path.sort(null);
	}
	public int compareTo(Board other) {
		// TODO Auto-generated method stub
		if(this.fScore < other.fScore)
			return -1;
		else if(this.fScore == other.fScore)
			return 0;
		else
			return 1;
	}
	public boolean equals(Object other){
		boolean isEqual = true;
		for(int i =0;i<3;i++){
			for(int j=0;j<3;j++){
				if(this.numbers[i][j] != ((Board)other).numbers[i][j])
					isEqual = false;
					
			}
		}
		return isEqual;
		
	}

}
