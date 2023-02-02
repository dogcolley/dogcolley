#include <iostream>
using namespace std;

struct Book
{
    string title;
    string author;
    int price;
};

void Display(const Book&);


int main(void){

    int A = 0 ;
    int& B = A;
    int C = A;

    A = 1;

    cout << "A : " << A << endl;
    cout << "B : " << B << endl;
    cout << "C : " << C << endl;

    Book web_book = {"HTML과 CSS", "홍길동", 28000};
    Display(web_book);
}

void Display(const Book& bk)
{
    cout << "책의 제목은 " << bk.title << "이고, ";
    cout << "저자는 " << bk.author << "이며, ";
    cout << "가격은 " << bk.price << "원입니다." << endl; 
}

