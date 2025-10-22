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


    /********************************
    Developer: [Ishita Naik]
    University ID: [24019990]
    Function: This function takes two integers as input — the first number is the base and the second one is the exponent.
    It returns the result of raising the base to the power of the exponent.
    Example: Power(2, 3) returns 8.
    ********************************/
    public int Power(int base, int exponent) {
        return (int) Math.pow(base, exponent);
    }

    // try

        /********************************
    Developer: Jacob Ebrada
    University ID: 240364687
    Function: This function takes two inputs as integers and returns the mulitplication
    ********************************/
    public int Multi(int num1, int num2){
        return (num1*num2);
    }
    /********************************
    Developer: Jacob Ebrada
    University ID: 240364687
    Function: This function takes two inputs as integers and returns the division
    ********************************/
    public int Divide(int num1 int num2){
        return (num1num2);
    }

}