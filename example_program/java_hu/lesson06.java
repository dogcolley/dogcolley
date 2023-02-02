import java.util.Scanner;

public class lesson06 {
	// 1.string 비교
	// 2.array 
	public static void main(String[] args) {
			// String비교와 배열 할당 힙할당= 중요 , 스텍= 안중요
			String txt = "stringTest"; // alias : 별칭  , 메모리에 저장된 0xFF 이런식으로 저장되었으면 이걸 우린 txt로 사용한다.
			if(txt.equals("stringTest")){
				System.out.println("문자 비교문은 저렇게");
			}
			
			if(txt.equalsIgnoreCase("stringtest")){
				System.out.println("문자 비교문은 저렇게 : 대소문자 비교가없음");
			}
		
			String a = "test";
			String b = "test";
			String c = new String("test");
			System.out.println(a == b); //true;
			System.out.println(a == c); //false;
			
			//배열 변수명은 스텍에 배열들은 힙에
			int array_a[] = new int[5];
			array_a[0] = 0;
			array_a[1] = 1;
			array_a[2] = 2;
			array_a[3] = 3;
			array_a[4] = 4;
			
			
			String array_b[] = new String[1];
			array_b[0] = "test";
			String d = array_b[0];
			String e = "test";
			System.out.println(array_b[0] == d);
			System.out.println(array_b[0] == e);
			System.out.println(array_b[0] == a);
			
			for(int i = 0 ; i < array_a.length; i++) {
				System.out.println(array_a[i]);
			}
			
			int array_c[] = {1,2,3,4,5,6};
			
			int array_d[] = new int[12];
			array_d[0] = 1;
			System.out.println("=================");
			System.out.println(array_d[0]);
			for(int i = 1; i < array_d.length; i++) {
				array_d[i] = array_d[i-1] * (i+1); 		
				System.out.println(array_d[i]);
			}
			
			
			// 과제 1
			// 1 ~ 45 번째까지의 피보나치 수를 배열에 저장하고 출력하시오.
			// 출력 예시) 1 1 2 3 5 8 ..... 
			
			int i = 1 ;
			int array_e[] = new int[45];
			while(i < 46) {
				if(i < 3 )array_e[i-1] = 1;
				else array_e[i-1] = array_e[i-2] + array_e[i-3];
				System.out.print(array_e[i-1]+" / ");
				i++;
			}
			

			
	}

}
