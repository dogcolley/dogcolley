
public class lesson11 {

	public static void main(String[] args) {
		// 객체 OPP 프로그램
		// 클래스, 객체, 인덱스
		
		Car dewo;
		dewo = new Car("대우1번차");
		System.out.print(dewo.name);
		echo a;
		a = new echo();
		
		people dogcolley;
		dogcolley = new people("dogcolley");
		dogcolley.traning();
		dogcolley.showHp();
		dogcolley.eatFood("감자");
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
	//생성자
	Car (String name){
		this.name = name;
	}
	
	String getName() {
		return name;
	}
	
	
}

class echo {
	
	echo(){
		System.out.println("인스턴트");
	}
}