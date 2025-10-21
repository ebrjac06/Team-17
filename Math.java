public class Math {
    // Functions will be added here by each team member
       /********************************
Developer: Mohammed Talha
University ID: 240207029 
********************************/
    public class Main { 
        // Returns the maximum of two integers
        public static int max(int a, int b) {
            return (a > b) ? a : b;
        }
    
        public static void main(String[] args) {
            int x = 10, y = 20;
            System.out.println("Max: " + max(x, y)); // Output: Max: 20
        }
    }
     /********************************
Developer: Mohammed Talha
University ID: 240207029
********************************/
    public class Main {
        public static int min(int a, int b) {
            return (a < b) ? a : b;
        }
    
        public static void main(String[] args) {
            System.out.println(min(10, 5));   // Output: 5
            System.out.println(min(-3, 7));   // Output: -3
        }

}