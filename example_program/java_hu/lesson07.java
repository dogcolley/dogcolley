
public class lesson07 {

	public static void main(String[] args) {
		// 1. ���� ��Ʈ (���İ�ǰ)
		// 2. ���� �� ����
		// 3. �żҵ� => class ����
		// 4.  call by reference
		// 5. call by value 
		
		
		String global_txt ="������!";
		
		
		// �޼ҵ�

		int[] array_a = {1,2,3,4};
		int[] array_b = array_a;
		reference(array_a);//4���� �迭 50���� �ٲٴ��Լ�
		System.out.println(array_a[3]); //50���
		System.out.println(array_b[3]); //50���
		
		int a = fx(1);
		System.out.print(a);
		echo("�����");
		if(isNegative(array_a))echo("�����ִ�");
		else echo("����������");
		
		
		String textText = "���� �л���̲�";
		txtChange(textText);
		System.out.println(textText);
		
		//���� 0 int �� �迭�� �Է¹޾� 10�̻��� ���ڰ� ����� ����ϴ��Լ� : ��ȯ�� ��Ʈ
		//���� 
		System.out.println("���� �迭�� ������ 10�̻��ΰ� ī����:"+sugge01(array_a));
		
		//���� 1. ¦������ Ȧ������ ����ϴ� �Լ��Դϴ�.
		//�Լ��� ��ȯ�� String
		int test01 = 2;
		System.out.println("Ȧ¦ ���б� ����? :"+sugge02(test01));
		
		//�׽�Ʈ 
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
	
	//�߿�
	public static void reference(int arr[]) {
		arr[3] = 50;
	}
	//�߿�
	public static String txtChange(String txt) {
		txt ="�̰� �ƹ��� �ٲ㵵 ��¾ȉ�";
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
		String txt = a % 2 == 0 ? "¦��" : "Ȧ��";
		return txt;
	}
	
	public static void test(int a) {
		int testing = a;
		testing = 20;
				
	}
	
}
