import java.util.Scanner;

public class lesson05 {

	public static void main(String[] args) {
		//while(���ǽ�)
		/*
		int a = 0;
		while(true) {
			a++;
			System.out.println("while��");
			if(a ==10)break;
		}
		
		for(int i = 0; i <10; i++){
			System.out.println(i+1+"ȸ");
			if(i == 5) {
				continue;
			}
		}
		System.out.println("i for ����");
		int z = 0;
		System.out.println(z);
		int test = z++ + 7;
		System.out.println(z);
		System.out.println(test);
		*/
		
		
		//�����Է� ���ɳ�
		Scanner sc = new Scanner(System.in);
		//����1
		/*
		System.out.println("�������� �Է��ϼ���");
		int num = sc.nextInt();	
		for(int i=1; i<10; i++) {
			System.out.print(num * i + " ");
		}
		*/
		
		// ���� 2
		// ���ﰢ��
		// ���� N�� �޾Ƽ�
		// ���� ��ŭ ���� �����ÿ�
		// ����) N�� 5�϶�
		//	   *
		//    ***
		//   *****
		//  *******
		// *********
		
		/*
		System.out.println("������ ������ �Է��ϼ���");
		int cellStar = sc.nextInt();	
		int StarNum = 0 ;
		for(int i=1; i<=cellStar; i++){
			int rowStar = cellStar * 2 - 1;
			if(i == 1) StarNum = i;
			else StarNum = i * 2 - 1;
			String Txt = "";
			for(int k = 0; k <=rowStar; k++){
				if(k > cellStar-i && StarNum > 0) {
					 Txt += "*";
					 StarNum--;
				}
				else Txt += " ";
				
			}
			System.out.println(Txt);
		}
		*/
		
		// ���� 3
		// ���丮��
		// �Է�) 1 <= x <=12
		// ���) x�� ���丮�� ���� ���϶�

		// �Է¿��� 5
		// ��¿��� 120
		System.out.println("���丮���� �� �� x �� �Է����ּ���. \n 13���� �۰� 0���� Ŀ���մϴ�.");
		int nums = sc.nextInt();
		int resulte = 1;
		while(nums <0 || nums> 12) {
			System.out.println("13���� �۰� 0���� Ŀ���մϴ�.");
			nums = sc.nextInt();
		}
		for(int i = 1 ; i <= nums; i++) {
			resulte *= i;
		}
		System.out.println("���丮���� : "+resulte);
		
	}

}
