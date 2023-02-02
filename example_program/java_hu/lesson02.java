import java.util.ArrayList;
import java.util.HashMap;

public class lesson02 {

	public static void main(String[] args) {
		
		
		// 변수의 잘못된 예
		// int 1st  //첫단어는 숫자x
		// int a# // 변수명에 특수문자x JS는 $에외 php$로 선언
		// int class // 키워드를 변수로
		
		// 변수종류 자주쓰는거
		
		//자료형 변수
		int test1 = 1;
		long test2 = 2;
		double test3 = 3;
		boolean test4 = true;
		char OneLang = 'a';
		float f = 0.001f; // f명시적인것 정밀도 차이
		String txtString = "나는텍스트";
		
		//이것도 나중 문자배열
		StringBuffer sb = new StringBuffer();
        sb.append("hello");
        sb.append(" ");
        sb.append("jump to java");
        
        
        //이것도 나중 배열 추가삭제가능
        ArrayList pitches = new ArrayList();
        pitches.add("138");
        pitches.add("129");
        pitches.add("142");
        
        //이것도 나중 JSON 같은놈
        HashMap<String, String> map = new HashMap<String, String>();
        map.put("people", "사람");
        map.put("baseball", "야구");
        
        
		// 변수마다의 용량 표시 
		/* 0은 -의 0은 제거 +0만 사용
		타입                   범위                 			          기본값       	   크기            형변화시 규칙: 밑으로 가는건 자동 위로는 수동!
		boolean    true, false 			 	      false 	1 byte
		byte	   \u0000~\ uffff (0~65,535)       0	   	1 byte
		char       -128~127'				      \ u 000'	2 byte
		short      -32,768~32,767				  0			2 byte
		int		   -2,147,483,648~2,147,483,647   0         4 byte
		long       -9223372036854775808           0L        8 byte
				   ~9223372036854775807  
		float	   1.4E-45~3.4028235E38           0.0f      4 byte
		double     4.9E-324~                      0.0 또는      8 byte
				   1.7976931348623157E308		  0.0d
		*/
        
        //형변환
        // 실수형값을 정수형으로 형변환함으로써 자리수를 잘라내는 것이다.
        //
        
        int good = (int)3.900001; //필수형변환  
        double a = 3.924592;
        double a2 = 3; //자동형변환
        double a3 = 7.0 /3.0 ;
        System.out.println("테스트"+(a *good) );
        System.out.println(a3);
        
        //출력테스트
		System.out.println(test1);
		System.out.println(test2);
		System.out.println(test3);
		System.out.println(test4);
		System.out.println(OneLang);
		System.out.println(txtString);
		System.out.println(map.get("people"));
		System.out.println(sb.toString());
		System.out.println(pitches);
		System.out.println(good);
		System.out.println(a);
		System.out.println(a2);
		System.out.println(f);
		
		
		//과제
		int assignment01 = 1+1;
		int assignment02 = 1-1;
		int assignment03 = 1+1; 
		int assignment04 = 1-1;
		int assignment05 = 1*2;
		int assignment06 = 2/2;
		int assignment07 = 3%2;
		char assignment08_1 = 'a'; 
		char assignment08_2 = 'b';
		int assignment08 = assignment08_1 + assignment08_2; //차셋은 합치면 유니코드로 반환된다.
		String assignment09_1 = "a"; //그러니 문자열 합치는건 스트링 + 스트링이 좋다.
		String assignment09_2 = "b";
		String assignment09 =  assignment09_1 +assignment09_2;
		String assignment10 = "랄랄랄라\n 랄랄랄라\n 랄랄랄라\n 랄랄랄라\n";
		double  assignment11 = 3.6;
		
		System.out.println("assignment01:"+assignment01);
		System.out.println("assignment02:"+assignment02);
		System.out.println("assignment03:"+assignment03);
		System.out.println("assignment04:"+assignment04);
		System.out.println("assignment05:"+assignment05);
		System.out.println("assignment06:"+assignment06);
		System.out.println("assignment07:"+assignment07);
		System.out.println("assignment08_1:"+assignment08_1);
		System.out.println("assignment08:"+assignment08);
		System.out.println("assignment08:"+assignment08);
		System.out.println("assignment09:"+assignment09);
		System.out.println("assignment10:"+assignment10);
		System.out.println("assignment11:"+assignment11);
		System.out.println("assignment11:"+(int)(assignment11+0.5)); // 어떤수 간에 0.5를 더한수 int로 반환하면 자동으로 버려지니 변환끝
		
	}

}
