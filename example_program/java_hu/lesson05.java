import java.util.Scanner;

public class lesson05 {

	public static void main(String[] args) {
		//while(조건식)
		/*
		int a = 0;
		while(true) {
			a++;
			System.out.println("while문");
			if(a ==10)break;
		}
		
		for(int i = 0; i <10; i++){
			System.out.println(i+1+"회");
			if(i == 5) {
				continue;
			}
		}
		System.out.println("i for 루프");
		int z = 0;
		System.out.println(z);
		int test = z++ + 7;
		System.out.println(z);
		System.out.println(test);
		*/
		
		
		//과제입력 스케너
		Scanner sc = new Scanner(System.in);
		//과제1
		/*
		System.out.println("구구단을 입력하세요");
		int num = sc.nextInt();	
		for(int i=1; i<10; i++) {
			System.out.print(num * i + " ");
		}
		*/
		
		// 과제 2
		// 별삼각형
		// 높이 N을 받아서
		// 높이 만큼 별을 찍으시오
		// 예시) N이 5일때
		//	   *
		//    ***
		//   *****
		//  *******
		// *********
		
		/*
		System.out.println("별사탕 갯수를 입력하세요");
		int cellStar = sc.nextInt();	
		int StarNum = 0 ;
		for(int i=1; i<=cellStar; i++){
			int rowStar = cellStar * 2 - 1;
			if(i == 1) StarNum = i;
			else StarNum = i * 2 - 1;
			String Txt = "";
			for(int k = 0; k <=rowStar; k++){
				if(k > cellStar-i && StarNum > 0) {
					 Txt += "*";
					 StarNum--;
				}
				else Txt += " ";
				
			}
			System.out.println(Txt);
		}
		*/
		
		// 과제 3
		// 펙토리얼
		// 입력) 1 <= x <=12
		// 출력) x의 펙토리얼 값을 구하라

		// 입력예시 5
		// 출력예시 120
		System.out.println("펙토리얼이 될 값 x 를 입려해주세요. \n 13보다 작고 0보단 커야합니다.");
		int nums = sc.nextInt();
		int resulte = 1;
		while(nums <0 || nums> 12) {
			System.out.println("13보다 작고 0보단 커야합니다.");
			nums = sc.nextInt();
		}
		for(int i = 1 ; i <= nums; i++) {
			resulte *= i;
		}
		System.out.println("펙토리얼값은 : "+resulte);
		
	}

}
