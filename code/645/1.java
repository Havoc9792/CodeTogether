import java.util.Scanner;
class assignmentone {
    
    final int publicKey = 43;
    final int privateKey = 19;
    
    //hei
    public int hashing(int message){
        int hash = 1;
        hash = message ^ 37 % 87;
        return hash;
    }
    
    //Tino
    public int encryption (int message){
        int output = (message^publicKey)%77;
        return output;
    } 
    //Tony
    public int sign(int message){
        int output = (message^privateKey)%65;
        return output;
        
    }
    
    public static void main (String[] args) {
        Scanner in = new Scanner(System.in);
        int message = in.nextInt();
        assignmentone a = new assignmentone();
        System.out.println(a.hashing(a.sign(a.encryption(message))));
        in.close();
        
    }
}
