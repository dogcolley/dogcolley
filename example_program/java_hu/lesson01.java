
public class lesson01 {

	public static void main(String[] args) {
		// TODO Auto-generated method stub
		
		System.out.print("hi java");
		
		System.out.print(1+1);
		System.out.print(1-1);
		System.out.print(1*2);
		System.out.print(2/2);
		System.out.print(3%2);
		System.out.print('a');
		System.out.print('a'+'b');
		System.out.print("랄랄랄라\n 랄랄랄라\n 랄랄랄라\n 랄랄랄라\n");
		System.out.print(1+2 / (2 * 4 ) + "바보");
		System.out.print("");
		
		
        String Text = "Hello World";
        byte[] byteText = Text.getBytes(); // 문자열을 바이트코드로 변환시켜서 배열 하나하나에 저장시킴.
       
        System.out.println("---문자열과, 바이트코드로 인코딩한 결과---");
        System.out.println("Text : " + Text);
        System.out.println("byte_Text : " + byteText); // 바이트코드로 인코딩한 배열의 주소를 출력하고있음.
        System.out.println("byte_Text.toString() : " + byteText.toString());
       
        System.out.println("\r---문자를 바이트코드로 표현한 결과---");
        for(int i=0; i<Text.length(); i++)
            System.out.println("Character [" + Text.charAt(i) + "] To ASCII Code : " + byteText[i]);
       
        String byteToText = new String(byteText);
        System.out.println("\r---바이트코드에서 문자열로 디코딩한 결과---");
        System.out.println(byteToText);
        
        
        
        // 문자를 아스키 코드 (10진수) 로 변환 출력
        System.out.println((int) 'A'); // 65

        // 문자를 유니코드 코드 (10진수) 로 변환 출력
        System.out.println((int) '가'); // 44032


        // 문자를 아스키 코드 (16진수) 로 변환 출력
        System.out.format("0x%02X%n", (int) 'A'); // 0x41

        // 문자를 유니코드 코드 (16진수) 로 변환 출력
        System.out.format("0x%04X%n", (int) '가'); // 0xAC00



        // 코드 번호를 문자로 변환 출력
        System.out.println((char) 65); // A
        System.out.println((char) 0x41); // A (이것은 16진수로 'A'를 출력한 예제)

        // 코드 번호를 문자로 변환 출력 (한글)
        System.out.println((char) 0xAC00); // 가
        // TODO 내일할 수업은
        // window 
         
	}

}
