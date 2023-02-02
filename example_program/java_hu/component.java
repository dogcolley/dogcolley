
public class component {
	String main;
	String header;
	String footer;
	
	void set(String taget, String tag) {
		if(taget == "header") {
			header = tag;
		}else if(taget == "footer") {
			footer = tag;
		}else if(taget == "main") {
			main = tag;
		}else {
			System.out.println("해당 태그는 없습니다. header/footer/main 으로만 추가해주세요."); 
		}
	}
	
	void remove(String taget) {
		if(taget == "header") {
			header = "";
		}else if(taget == "footer") {
			footer = "";
		}else if(taget == "main") {
			main = "";
		}else {
			System.out.println("해당 태그는 없습니다. header/footer/main 으로만 추가해주세요."); 
		}
	}
	
	
	
	void renderTag () {
		String tag = header + main + footer;
		System.out.println("<div id='app'>"+tag+"</div>"); 
	}
	
	
}
