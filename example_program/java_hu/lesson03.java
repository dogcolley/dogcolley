
public class lesson03 {

	public static void main(String[] args) {
		boolean isGood = true;
		System.out.print(isGood);
		int test1 = 123;
		int test2 = 123;
		String a = "asdf"; //��ģ����� ��������� ������
		String c = "asdf"; //��ģ����� ��������� ������
		boolean test = test1 < test2;
		
		class Man extends Object {
			int year;
			String gender; 
			
			
		}
		
		Man jsh = new Man();
		jsh.year = 25;
		jsh.gender = "man";
	
		// 20�� ���ڸ� ����մϴ�.
		if(jsh.year < 20 ) {
			System.out.println("��ϴ�. out");
		}else if(jsh.gender == "����"){
			System.out.println("�����Դϴ�. out");
		}else {
			System.out.println("����Դϴ�.");
		}
		
		
		if(10%2 ==0) {
			//Ʈ�簡�Ǿ� ���
		}else {
			//�ٸ����� �־��ٸ� �ǰ���
		}
		
		boolean and = true && true;
		boolean or = true || false;
		boolean not = !true;
		
		
		boolean dogHg = true;
		boolean CatHg = false;
		
		if(dogHg && CatHg) {
			System.out.println("�Ѵ� ��������� �����.");
		}
		/*
		 * ���� 1
		 * 
		������ �־����� ��, �����̸� 1, �ƴϸ� 0�� ����ϴ� ���α׷��� �ۼ��Ͻÿ�.
		
		������ ������ 4�� ����̸鼭, 100�� ����� �ƴ� �� �Ǵ� 400�� ����� �� �̴�.
		
		�������, 2012���� 4�� ����� ����������, 1900���� 4�� ���������, 100�� ����̱� ������ ������ �ƴϴ�.
		
		������, 2000���� 400�� ����̱� ������ �����̴�.

		*/
		
		int yunYear  = 2000;
		
		if(	(yunYear % 4 == 0 && !(yunYear % 100 == 0)) || yunYear % 400 == 0 ){
			System.out.println("����");
		}
		
		int num1 = 1;
		int num2 = 2;
		int num3 = 3;
		
		if(num1 >num2) {
			if(num3>num1)System.out.println("num1 �� 2������ ũ��.");
			else System.out.println("num3 �� 2������ ũ��.");
		}else if(num2 <num3){
			System.out.println("num1 �� 2������ ũ��.");
		}else System.out.println("num3 �� 2������ ũ��.");
		
		
		
		//2���
		if( (num1 >num2 && num3 > num1) || (num1 >num3 && num2 > num1) )System.out.println("2������ ū�� NUM1");
		if( (num2 >num3 && num1 > num2) || (num2 >num1 && num3 > num2) )System.out.println("2������ ū�� NUM2");
		if( (num3 >num2 && num1 > num3) || (num3 >num1 && num2 > num3) )System.out.println("2������ ū�� NUM3");

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
