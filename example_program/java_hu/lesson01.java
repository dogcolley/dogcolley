
public class lesson01 {

	public static void main(String[] args) {
		// TODO Auto-generated method stub
		
		System.out.print("hi java");
		
		System.out.print(1+1);
		System.out.print(1-1);
		System.out.print(1*2);
		System.out.print(2/2);
		System.out.print(3%2);
		System.out.print('a');
		System.out.print('a'+'b');
		System.out.print("��������\n ��������\n ��������\n ��������\n");
		System.out.print(1+2 / (2 * 4 ) + "�ٺ�");
		System.out.print("");
		
		
        String Text = "Hello World";
        byte[] byteText = Text.getBytes(); // ���ڿ��� ����Ʈ�ڵ�� ��ȯ���Ѽ� �迭 �ϳ��ϳ��� �����Ŵ.
       
        System.out.println("---���ڿ���, ����Ʈ�ڵ�� ���ڵ��� ���---");
        System.out.println("Text : " + Text);
        System.out.println("byte_Text : " + byteText); // ����Ʈ�ڵ�� ���ڵ��� �迭�� �ּҸ� ����ϰ�����.
        System.out.println("byte_Text.toString() : " + byteText.toString());
       
        System.out.println("\r---���ڸ� ����Ʈ�ڵ�� ǥ���� ���---");
        for(int i=0; i<Text.length(); i++)
            System.out.println("Character [" + Text.charAt(i) + "] To ASCII Code : " + byteText[i]);
       
        String byteToText = new String(byteText);
        System.out.println("\r---����Ʈ�ڵ忡�� ���ڿ��� ���ڵ��� ���---");
        System.out.println(byteToText);
        
        
        
        // ���ڸ� �ƽ�Ű �ڵ� (10����) �� ��ȯ ���
        System.out.println((int) 'A'); // 65

        // ���ڸ� �����ڵ� �ڵ� (10����) �� ��ȯ ���
        System.out.println((int) '��'); // 44032


        // ���ڸ� �ƽ�Ű �ڵ� (16����) �� ��ȯ ���
        System.out.format("0x%02X%n", (int) 'A'); // 0x41

        // ���ڸ� �����ڵ� �ڵ� (16����) �� ��ȯ ���
        System.out.format("0x%04X%n", (int) '��'); // 0xAC00



        // �ڵ� ��ȣ�� ���ڷ� ��ȯ ���
        System.out.println((char) 65); // A
        System.out.println((char) 0x41); // A (�̰��� 16������ 'A'�� ����� ����)

        // �ڵ� ��ȣ�� ���ڷ� ��ȯ ��� (�ѱ�)
        System.out.println((char) 0xAC00); // ��
        // TODO ������ ������
        // window 
         
	}

}
