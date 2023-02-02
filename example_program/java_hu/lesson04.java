import java.util.Scanner;

public class lesson04 {

	public static void main(String[] args) {
		// 1. Scanner
		
		Scanner sc = new Scanner(System.in);
		//int input01 = sc.nextInt();
		//String input02 = sc.next(); // or nextLine(); 단어, 문장
		//String input03 = sc.nextLine(); // or nextLine(); 단어, 문장
		
		//System.out.println(input01);
		//System.out.println(input02);
		//System.out.println(input03);
		
		boolean test01 = false;
		System.out.println(test01 ? "진실" : "거짓");  
		
		// x = x + 1;
		// x += 1;
		// x ++;
		
		//int idx = 3;
		String idx = "호우!";
		switch(idx) { // 문자열과 숫자 소수점이없는
			case "하!":
				System.out.println("3이란다");		
			break;
			
			default:
				System.out.println("안녕");		
		}
		
		// for 문 기본형 ( 초기식;조건식;증감식)

		//과제 int N의 값을 받아서
		//N 높이의 별 삼각형을 만들자
		int rp = sc.nextInt();
		for(int i=0;i<rp;i++) {
			String txt = "*";
			for(int j=0; j < i; j++) {
				txt +="*";
			}	
			System.out.println(txt);
		}
		
		//1~ 100의 짝수
		String txt2 = "";
		for(int k=1;k<=100;k++) {
			if(k %2 ==0)txt2 += " "+k;
		}
		System.out.println(txt2);
	}

}
