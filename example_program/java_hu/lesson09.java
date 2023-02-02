
public class lesson09 {
	static int a = 3; // 전역변수
	
	public static void main(String[] args) {
		
		//01.전역변수
		a++; //선언1
		lesson09.a++; //선언2
		addA(); //선언3
		System.out.println(a);
		int a = 90; //지역이 우선 출력시
		System.out.println(a);
		
		//02. format 
		System.out.format("안녕하세요\n");
		System.out.println("안녕하세요");
		
		System.out.format("%d안녕하세요%d\n",a,a);
        System.out.println(a+"안녕하세요"+a);
		
		float b = 1.75f;
		String c = "ㅋㅋ";
		System.out.format("%d",a);
		System.out.println();
		System.out.format("%f",b);
		System.out.println();
		System.out.format("%s",c);
		System.out.println();
		System.out.format("%x",a);
		System.out.println();
		System.out.format("%X",a);
		System.out.println();
		System.out.format("%o",a);
		System.out.println();
		
		//03 2진수 표기
		System.out.format(Integer.toBinaryString(a));
		requer(10);
		System.out.println(pow(10,0));
		
		System.out.println(pibo(6));
		
		//04 과제 팩토리얼 
		//ex) input ) 7 outPut 5040;
		System.out.println(pack(4));
	
	}
	
	public static int pack(int x) {
		if(x ==1)return 1;
		return x * pack (x-1);
	}
	
	public static int pibo(int x) {
		if(x <= 2)return 1;
		return pibo(x-1) + pibo(x-2); 
	}
	
	public static int pow(int x,int n) {
		if(n <= 0) return 1;
		if(n == 1) return x;
		return x * pow(x,n-1);
	}
	public static void requer(int a) {
		if(a==0)return;
		System.out.println("문어는 빙빙 돌아갑니다.");
		requer(a-1);
		
	}
	public static void addA() {
		a++;
	}

}
