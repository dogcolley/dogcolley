import java.util.ArrayList;
import java.util.HashMap;

public class lesson02 {

	public static void main(String[] args) {
		
		
		// ������ �߸��� ��
		// int 1st  //ù�ܾ�� ����x
		// int a# // ������ Ư������x JS�� $���� php$�� ����
		// int class // Ű���带 ������
		
		// �������� ���־��°�
		
		//�ڷ��� ����
		int test1 = 1;
		long test2 = 2;
		double test3 = 3;
		boolean test4 = true;
		char OneLang = 'a';
		float f = 0.001f; // f������ΰ� ���е� ����
		String txtString = "�����ؽ�Ʈ";
		
		//�̰͵� ���� ���ڹ迭
		StringBuffer sb = new StringBuffer();
        sb.append("hello");
        sb.append(" ");
        sb.append("jump to java");
        
        
        //�̰͵� ���� �迭 �߰���������
        ArrayList pitches = new ArrayList();
        pitches.add("138");
        pitches.add("129");
        pitches.add("142");
        
        //�̰͵� ���� JSON ������
        HashMap<String, String> map = new HashMap<String, String>();
        map.put("people", "���");
        map.put("baseball", "�߱�");
        
        
		// ���������� �뷮 ǥ�� 
		/* 0�� -�� 0�� ���� +0�� ���
		Ÿ��                   ����                 			          �⺻��       	   ũ��            ����ȭ�� ��Ģ: ������ ���°� �ڵ� ���δ� ����!
		boolean    true, false 			 	      false 	1 byte
		byte	   \u0000~\ uffff (0~65,535)       0	   	1 byte
		char       -128~127'				      \ u 000'	2 byte
		short      -32,768~32,767				  0			2 byte
		int		   -2,147,483,648~2,147,483,647   0         4 byte
		long       -9223372036854775808           0L        8 byte
				   ~9223372036854775807  
		float	   1.4E-45~3.4028235E38           0.0f      4 byte
		double     4.9E-324~                      0.0 �Ǵ�      8 byte
				   1.7976931348623157E308		  0.0d
		*/
        
        //����ȯ
        // �Ǽ������� ���������� ����ȯ�����ν� �ڸ����� �߶󳻴� ���̴�.
        //
        
        int good = (int)3.900001; //�ʼ�����ȯ  
        double a = 3.924592;
        double a2 = 3; //�ڵ�����ȯ
        double a3 = 7.0 /3.0 ;
        System.out.println("�׽�Ʈ"+(a *good) );
        System.out.println(a3);
        
        //����׽�Ʈ
		System.out.println(test1);
		System.out.println(test2);
		System.out.println(test3);
		System.out.println(test4);
		System.out.println(OneLang);
		System.out.println(txtString);
		System.out.println(map.get("people"));
		System.out.println(sb.toString());
		System.out.println(pitches);
		System.out.println(good);
		System.out.println(a);
		System.out.println(a2);
		System.out.println(f);
		
		
		//����
		int assignment01 = 1+1;
		int assignment02 = 1-1;
		int assignment03 = 1+1; 
		int assignment04 = 1-1;
		int assignment05 = 1*2;
		int assignment06 = 2/2;
		int assignment07 = 3%2;
		char assignment08_1 = 'a'; 
		char assignment08_2 = 'b';
		int assignment08 = assignment08_1 + assignment08_2; //������ ��ġ�� �����ڵ�� ��ȯ�ȴ�.
		String assignment09_1 = "a"; //�׷��� ���ڿ� ��ġ�°� ��Ʈ�� + ��Ʈ���� ����.
		String assignment09_2 = "b";
		String assignment09 =  assignment09_1 +assignment09_2;
		String assignment10 = "��������\n ��������\n ��������\n ��������\n";
		double  assignment11 = 3.6;
		
		System.out.println("assignment01:"+assignment01);
		System.out.println("assignment02:"+assignment02);
		System.out.println("assignment03:"+assignment03);
		System.out.println("assignment04:"+assignment04);
		System.out.println("assignment05:"+assignment05);
		System.out.println("assignment06:"+assignment06);
		System.out.println("assignment07:"+assignment07);
		System.out.println("assignment08_1:"+assignment08_1);
		System.out.println("assignment08:"+assignment08);
		System.out.println("assignment08:"+assignment08);
		System.out.println("assignment09:"+assignment09);
		System.out.println("assignment10:"+assignment10);
		System.out.println("assignment11:"+assignment11);
		System.out.println("assignment11:"+(int)(assignment11+0.5)); // ��� ���� 0.5�� ���Ѽ� int�� ��ȯ�ϸ� �ڵ����� �������� ��ȯ��
		
	}

}
