#include <iostream>
#include <stdio.h>
#include <string>
using namespace std;

//구조체의 기본

struct book
{
    string  title;
    string author;
    int     price;
};

struct Prop

{

    int savings;

    int loan;

};

int CalcProperty(int, int);

int CalcProperty(int s, int l)

{

    return (s - l);

}

int CalcProperty2(Prop*);
int CalcProperty2(Prop* money)
{
	money->savings = 100; // 호출된 함수에서 원본 구조체의 데이터를 변경
	return (money->savings - money->loan);
}

struct Name

{
    string first;
    string last;
};

struct Friends
{
    Name first_name;
    string address;
    string job;
};




int main(void)
{


	book web_book = {"HTML과 CSS", "홍길동", 28000};
	book java_book = {"Java language", "이순신"};
	
	cout << "첫 번째 책의 제목은 " << web_book.title << "이고, 저자는 " << web_book.author << "이며, 가격은 " << web_book.price << "원입니다." << endl;
	cout << "두 번째 책의 제목은 " << java_book.title << "이고, 저자는 " << java_book.author << "이며, 가격은 " << java_book.price << "원입니다." << endl;

	int hong_prop,hong_prop2;
    Prop hong = {10000000, 4000000};

	//매게 변수로 인자값을 전달후 출력
	hong_prop = CalcProperty(hong.savings, hong.loan); // 구조체의 멤버 변수를 함수의 인수로 전달함
	cout << "홍길동의 재산은 적금 " << hong.savings << "원에 대출 " << hong.loan << "원을 제외한 총 " << hong_prop << "원입니다."  << endl;

	//직접변경
	hong_prop2 = CalcProperty2(&hong); 
	cout << "홍길동의 재산은 적금 " << hong.savings << "원에 대출 " << hong.loan << "원을 제외한 총 " << hong_prop2 << "원입니다."  << endl;

	//외부 호출
	Friends hongs = 
	{
		{ "길동", "홍" },
		"서울시 강남구 역삼동",
		"학생"
	};

	cout << hongs.address << endl << endl;
	cout << hongs.first_name.last << hongs.first_name.first << "에게," << endl;
	cout << "그동안 잘 지냈니? 아직도 " << hongs.job << "이니?" << endl;
	cout << "다음에 꼭 한번 보자." << endl << "잘 지내."<< endl;




}