import java.sql.Blob;
import java.util.ArrayList;
import java.util.Arrays;
import java.util.Collections;

public class lesson10 {

	public static void main(String[] args) {
		// 1. 램덤
		double a = Math.random();
		System.out.println((int)(a*10)+1);
		System.out.println(functionA(30,45));
		
		// 2. 최대공약수
		System.out.println(functionB(30,45));
		
		// 3. 자바 루트구하기
		System.out.println(Math.sqrt(4));
		
		// 4. arrayList
		
		ArrayList<Integer> arr = new ArrayList<Integer>() ;

		functionC(25,arr);
		System.out.println(arr);
		
		// 과제 소수 구하기
		ArrayList<Integer> arr2 = new ArrayList<Integer>() ;
		functionD(1000,arr2);
		System.out.println(arr2);
		
	}
	
	public static int functionA (int a, int b) {
		int get_a = a;
		int get_b = b;
		int g_cc = 1;
		for(int i = 1 ; i <= get_a || i <= get_b; i++) {
			if((get_a % i == 0 ) && (get_b % i==0))g_cc = i;
		}
		return g_cc;
	}
	
	public static int functionB (int a, int b) {
		int A, B, C;
		 A = a > b ? a : b; //처음에만 작아야함
		 B = a < b ? a : b;
		while( B != 0 ) {
			 C = A%B;	
			 A = B;
			 B = C;
		}
		return A;
			
	}

	public static void functionC (int a,ArrayList<Integer> arr) {
		//System.out.println(Math.sqrt(a));
		arr.add(1);
		for(int i = 2; i <= Math.sqrt(a); i ++) {
			if(a %i == 0) {
				arr.add(i);
				if(i*i != a) arr.add(a / i);
			}
		}
		arr.add(a);
		Collections.sort(arr);
	}
	
	public static void functionD (int a,ArrayList<Integer> arr) {
		while( a >= 0) {
			int cc = 0;
			for(int i = 2; i <= Math.sqrt(a); i ++) {
				if(a %i == 0) {
					cc++;
					break;
				}
			}
			if(cc==0)arr.add(a);
			a--;
		}
		
		
		
	}
}
