import java.util.Scanner;

public class lesson04 {

	public static void main(String[] args) {
		// 1. Scanner
		
		Scanner sc = new Scanner(System.in);
		//int input01 = sc.nextInt();
		//String input02 = sc.next(); // or nextLine(); �ܾ�, ����
		//String input03 = sc.nextLine(); // or nextLine(); �ܾ�, ����
		
		//System.out.println(input01);
		//System.out.println(input02);
		//System.out.println(input03);
		
		boolean test01 = false;
		System.out.println(test01 ? "����" : "����");  
		
		// x = x + 1;
		// x += 1;
		// x ++;
		
		//int idx = 3;
		String idx = "ȣ��!";
		switch(idx) { // ���ڿ��� ���� �Ҽ����̾���
			case "��!":
				System.out.println("3�̶���");		
			break;
			
			default:
				System.out.println("�ȳ�");		
		}
		
		// for �� �⺻�� ( �ʱ��;���ǽ�;������)

		//���� int N�� ���� �޾Ƽ�
		//N ������ �� �ﰢ���� ������
		int rp = sc.nextInt();
		for(int i=0;i<rp;i++) {
			String txt = "*";
			for(int j=0; j < i; j++) {
				txt +="*";
			}	
			System.out.println(txt);
		}
		
		//1~ 100�� ¦��
		String txt2 = "";
		for(int k=1;k<=100;k++) {
			if(k %2 ==0)txt2 += " "+k;
		}
		System.out.println(txt2);
	}

}
