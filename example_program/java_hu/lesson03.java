
public class lesson03 {

	public static void main(String[] args) {
		boolean isGood = true;
		System.out.print(isGood);
		int test1 = 123;
		int test2 = 123;
		String a = "asdf"; //이친구들로 블리언넣으면 에러뜸
		String c = "asdf"; //이친구들로 블리언넣으면 에러뜸
		boolean test = test1 < test2;
		
		class Man extends Object {
			int year;
			String gender; 
			
			
		}
		
		Man jsh = new Man();
		jsh.year = 25;
		jsh.gender = "man";
	
		// 20살 여자만 통과합니다.
		if(jsh.year < 20 ) {
			System.out.println("어립니다. out");
		}else if(jsh.gender == "남자"){
			System.out.println("남자입니다. out");
		}else {
			System.out.println("통과입니다.");
		}
		
		
		if(10%2 ==0) {
			//트루가되어 통과
		}else {
			//다른수를 넣었다면 되겠죠
		}
		
		boolean and = true && true;
		boolean or = true || false;
		boolean not = !true;
		
		
		boolean dogHg = true;
		boolean CatHg = false;
		
		if(dogHg && CatHg) {
			System.out.println("둘다 배고프구나 밥먹장.");
		}
		/*
		 * 과제 1
		 * 
		연도가 주어졌을 때, 윤년이면 1, 아니면 0을 출력하는 프로그램을 작성하시오.
		
		윤년은 연도가 4의 배수이면서, 100의 배수가 아닐 때 또는 400의 배수일 때 이다.
		
		예를들어, 2012년은 4의 배수라서 윤년이지만, 1900년은 4의 배수이지만, 100의 배수이기 때문에 윤년이 아니다.
		
		하지만, 2000년은 400의 배수이기 때문에 윤년이다.

		*/
		
		int yunYear  = 2000;
		
		if(	(yunYear % 4 == 0 && !(yunYear % 100 == 0)) || yunYear % 400 == 0 ){
			System.out.println("윤년");
		}
		
		int num1 = 1;
		int num2 = 2;
		int num3 = 3;
		
		if(num1 >num2) {
			if(num3>num1)System.out.println("num1 가 2번쨰로 크다.");
			else System.out.println("num3 가 2번쨰로 크다.");
		}else if(num2 <num3){
			System.out.println("num1 가 2번쨰로 크다.");
		}else System.out.println("num3 가 2번쨰로 크다.");
		
		
		
		//2대안
		if( (num1 >num2 && num3 > num1) || (num1 >num3 && num2 > num1) )System.out.println("2번쨰로 큰건 NUM1");
		if( (num2 >num3 && num1 > num2) || (num2 >num1 && num3 > num2) )System.out.println("2번쨰로 큰건 NUM2");
		if( (num3 >num2 && num1 > num3) || (num3 >num1 && num2 > num3) )System.out.println("2번쨰로 큰건 NUM3");

		int n1 = 3;
		int n2 = 1;
		int n3 = 7;
		
		if(n1 > n2) {
			n1 ^= n2;
			n2 ^= n1;
			n1 ^= n2;
		}
		if(n2 > n3) {
			n2 ^= n3;
			n3 ^= n2;
			n2 ^= n3;
		}
		if(n1 > n2) {
			n1 ^= n2;
			n2 ^= n1;
			n1 ^= n2;
		}
		System.out.println(n2);
		
		int op1 = 4;
		int op2 = 6;
		op1 ^= op2;
		
		op1 ^= op2;
		System.out.println(op1);
		op2 ^= op1;
		System.out.println(op1);
		op1 ^= op2;
		System.out.println(op1);
	}

}
