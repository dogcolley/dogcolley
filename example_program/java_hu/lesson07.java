
public class lesson07 {

	public static void main(String[] args) {
		// 1. 버블 소트 (정렬거품)
		// 2. 복습 힙 스텍
		// 3. 매소드 => class 선언
		// 4.  call by reference
		// 5. call by value 
		
		
		String global_txt ="하하하!";
		
		
		// 메소드

		int[] array_a = {1,2,3,4};
		int[] array_b = array_a;
		reference(array_a);//4번쨰 배열 50으로 바꾸는함수
		System.out.println(array_a[3]); //50출력
		System.out.println(array_b[3]); //50출력
		
		int a = fx(1);
		System.out.print(a);
		echo("랄라라");
		if(isNegative(array_a))echo("음수있다");
		else echo("음수가없다");
		
		
		String textText = "이잉 압살라마이꾸";
		txtChange(textText);
		System.out.println(textText);
		
		//과제 0 int 형 배열을 입력받아 10이상인 숫자가 몇개인지 출력하는함수 : 반환은 인트
		//과제 
		System.out.println("과제 배열의 값들이 10이상인걸 카운터:"+sugge01(array_a));
		
		//과제 1. 짝수인지 홀수인지 출력하는 함수입니다.
		//함수의 반환은 String
		int test01 = 2;
		System.out.println("홀짝 구분기 값은? :"+sugge02(test01));
		
		//테스트 
		int testingNum = 10;
		test(testingNum);
		System.out.println(testingNum);
	}
	public static int fx(int x){
		return x;
	}
		
	public static void echo(String x){
		System.out.println(x);
	}
	
	public static int resulte(int a, int b){
		return a + b;
	}
	
	public static int minus(int a, int b){
		return a - b;
	}
	
	public static boolean isNegative(int arr[]) {
		for(int i=0; i < arr.length;i++) {
			if(arr[i] <0)return true;
		}
		return false;
	}
	
	public static int Value(int x) {
		x= 7;
		return 7;
	}
	
	//중요
	public static void reference(int arr[]) {
		arr[3] = 50;
	}
	//중요
	public static String txtChange(String txt) {
		txt ="이건 아무리 바꿔도 출력안됌";
		return txt;
	}

	public static int sugge01(int arr[]) {
		int nums = 0;
		for(int i = 0 ; i < arr.length; i++) {
			if(arr[i] >= 10) nums++;
		}
		return nums;
	}
	
	public static String sugge02(int a) {
		String txt = a % 2 == 0 ? "짝수" : "홀수";
		return txt;
	}
	
	public static void test(int a) {
		int testing = a;
		testing = 20;
				
	}
	
}
