import java.util.Scanner;

public class lesson06 {
	// 1.string ��
	// 2.array 
	public static void main(String[] args) {
			// String�񱳿� �迭 �Ҵ� ���Ҵ�= �߿� , ����= ���߿�
			String txt = "stringTest"; // alias : ��Ī  , �޸𸮿� ����� 0xFF �̷������� ����Ǿ����� �̰� �츰 txt�� ����Ѵ�.
			if(txt.equals("stringTest")){
				System.out.println("���� �񱳹��� ������");
			}
			
			if(txt.equalsIgnoreCase("stringtest")){
				System.out.println("���� �񱳹��� ������ : ��ҹ��� �񱳰�����");
			}
		
			String a = "test";
			String b = "test";
			String c = new String("test");
			System.out.println(a == b); //true;
			System.out.println(a == c); //false;
			
			//�迭 �������� ���ؿ� �迭���� ����
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
			
			
			// ���� 1
			// 1 ~ 45 ��°������ �Ǻ���ġ ���� �迭�� �����ϰ� ����Ͻÿ�.
			// ��� ����) 1 1 2 3 5 8 ..... 
			
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
