
public class people {
	String name;
	int Hp = 50;
	int Hungry = 0;
	
	people(String name){
		this.name = name;
		System.out.println("�ΰ����ÿϷ�");
		System.out.println("�̸� : "+name);
	}
	
	void setHp(int Hp) {
		
	}
	
	int getHp() {
		return Hp;
	}
	
	boolean isHungry() {
		if(Hungry > 50) {
			System.out.println(name + "��ҷ�");
			return false;
		}else {
			System.out.println(name + "�����");
			return true;
		}
	}
	
	void eatFood(String foodName) {
		System.out.println(name + ": ������ �Դ��� ["+foodName+"]");
		Hp += 10;	
	}
	
	void traning() {
		if(Hp > 10) {
			System.out.println(name + "���");
			Hungry -= 10;
		}else {
			System.out.println(name + "���ļ� ��� ���ؿ�");
		}
	}
	
	void showHp() {
		System.out.println(name + "���� ���� ü��" + Hp);
	}
	
}
