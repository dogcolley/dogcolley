
public class lesson09 {
	static int a = 3; // ��������
	
	public static void main(String[] args) {
		
		//01.��������
		a++; //����1
		lesson09.a++; //����2
		addA(); //����3
		System.out.println(a);
		int a = 90; //������ �켱 ��½�
		System.out.println(a);
		
		//02. format 
		System.out.format("�ȳ��ϼ���\n");
		System.out.println("�ȳ��ϼ���");
		
		System.out.format("%d�ȳ��ϼ���%d\n",a,a);
        System.out.println(a+"�ȳ��ϼ���"+a);
		
		float b = 1.75f;
		String c = "����";
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
		
		//03 2���� ǥ��
		System.out.format(Integer.toBinaryString(a));
		requer(10);
		System.out.println(pow(10,0));
		
		System.out.println(pibo(6));
		
		//04 ���� ���丮�� 
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
		System.out.println("����� ���� ���ư��ϴ�.");
		requer(a-1);
		
	}
	public static void addA() {
		a++;
	}

}
