
public class lesson11 {

	public static void main(String[] args) {
		// ��ü OPP ���α׷�
		// Ŭ����, ��ü, �ε���
		
		Car dewo;
		dewo = new Car("���1����");
		System.out.print(dewo.name);
		echo a;
		a = new echo();
		
		people dogcolley;
		dogcolley = new people("dogcolley");
		dogcolley.traning();
		dogcolley.showHp();
		dogcolley.eatFood("����");
		dogcolley.showHp();
		
		component App;
		App = new component();
		App.set("header", "<header></header>");
		App.set("footer", "<footer></footer>");
		App.set("main", "<main></main>");
		
		App.renderTag();
		
		App.remove("footer");
		
		App.renderTag();

		App.remove("zz");
		App.set("dwqd", "<main></main>");
		
	}	
	
}


class Car {
	String name;
	String vsname;
	//������
	Car (String name){
		this.name = name;
	}
	
	String getName() {
		return name;
	}
	
	
}

class echo {
	
	echo(){
		System.out.println("�ν���Ʈ");
	}
}