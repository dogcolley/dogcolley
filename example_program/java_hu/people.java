
public class people {
	String name;
	int Hp = 50;
	int Hungry = 0;
	
	people(String name){
		this.name = name;
		System.out.println("인간셋팅완료");
		System.out.println("이름 : "+name);
	}
	
	void setHp(int Hp) {
		
	}
	
	int getHp() {
		return Hp;
	}
	
	boolean isHungry() {
		if(Hungry > 50) {
			System.out.println(name + "배불렁");
			return false;
		}else {
			System.out.println(name + "배고파");
			return true;
		}
	}
	
	void eatFood(String foodName) {
		System.out.println(name + ": 맛나게 먹는중 ["+foodName+"]");
		Hp += 10;	
	}
	
	void traning() {
		if(Hp > 10) {
			System.out.println(name + "운동중");
			Hungry -= 10;
		}else {
			System.out.println(name + "지쳐서 운동을 못해요");
		}
	}
	
	void showHp() {
		System.out.println(name + "님의 현재 체력" + Hp);
	}
	
}
