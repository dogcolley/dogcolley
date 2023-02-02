#include <iostream>
using namespace std;

int main(){

    int i;
    float sum  = 0;
    float sum2 = 0;
    for (i = 0; i < 1000; i++)
    {
        sum += 1;
        sum2 += 0.1;
    }
    sum = sum * 0.1;
    cout << "1을 1000번 더한 합계후 0.1를 나누면 " << sum <<"입니다." << endl; 
    cout << "0.1을 1000번 더한 합계는 " << sum2 <<"입니다." << endl; 


    int num = 2147483647;
    cout << "변수 num에 저장된 값은 " << num << "입니다." << endl;  
    num = 2147483648;
    cout << "변수 num에 저장된 값은 " << num << "입니다." << endl;

    float num01 = 3.1415926535897932;  // float 타입의 유효 자릿수는 소수점 6자리
    cout << "변수 num01에 저장된 값은 " << num01 << "입니다." << endl;  
    double num02 = 3.1415926535897932; // double 타입의 유효 자릿수는 소수점 16자리
    cout << "변수 num02에 저장된 값은 " << num02 << "입니다." << endl;


    int num1 = 1;
    int num2 = 4;
    double result1 = num1 / num2;
    double result2 = (double) num1 / num2;
    double result3 = double (num1) / num2;
    cout << "result1에 저장된 값은 " << result1 << "입니다." << endl;
    cout << "result2에 저장된 값은 " << result2 << "입니다." << endl;
    cout << "result3에 저장된 값은 " << result3 << "입니다.";

    //연산자원리
    cout << "+ 연산자에 의한 결괏값은 " << num1 + num2 << "입니다." << endl;
    cout << "- 연산자에 의한 결괏값은 " << num1 - num2 << "입니다." << endl;
    cout << "* 연산자에 의한 결괏값은 " << num1 * num2 << "입니다." << endl;
    cout << "/ 연산자에 의한 결괏값은 " << num1 / num2 << "입니다." << endl;
    cout << "% 연산자에 의한 결괏값은 " << num1 % num2 << "입니다." << endl;

    //쉬프트원리
    cout << "~ 연산자에 의한 결괏값은 " << (~num1) << "입니다." << endl;
    cout << "<< 연산자에 의한 결괏값은 " << (num2 << 2) << "입니다." << endl;
    cout << ">> 연산자에 의한 결괏값은 " << (num2 >> 2) << "입니다." << endl;


    //사이즈와 타입 체크
    cout << " char형 데이터에 할당되는 메모리의 크기는 " << sizeof(char) << " 바이트입니다." << endl;
    cout << " short형 데이터에 할당되는 메모리의 크기는 " << sizeof(short) << " 바이트입니다." << endl;
    cout << " int형 데이터에 할당되는 메모리의 크기는 " << sizeof(int) << " 바이트입니다." << endl;
    cout << " long형 데이터에 할당되는 메모리의 크기는 " << sizeof(long) << " 바이트입니다." << endl;
    cout << " long long형 데이터에 할당되는 메모리의 크기는 " << sizeof(long long) << " 바이트입니다." << endl;
    cout << " float형 데이터에 할당되는 메모리의 크기는 " << sizeof(float) << " 바이트입니다." << endl;
    cout << " double형 데이터에 할당되는 메모리의 크기는 " << sizeof(double) << " 바이트입니다." << endl;
    cout << "long double형 데이터에 할당되는 메모리의 크기는 " << sizeof(long double) << " 바이트입니다." << endl;

    //문자열 처리 
    string dog;
    cout << "현재 dog 변수의 길이는 " << dog.length() << "입니다." << endl;
    dog = "Navi";
    cout << dog << "! 정말 이쁜 이름이네요!" << endl;
    cout << "현재 dog 변수의 길이는 " << dog.length() << "입니다." << endl;
    cout << "강아지 이름의 첫 글자는 바로 " << dog[0] << "입니다." << endl;

    //String 메소드

    //길이찾기
    string str, str1, str2, str3;
    str2 = "C++ Programming";
    cout << "문자열 str1의 길이는 " << str1.length() << "입니다." << endl;
    cout << "문자열 str1의 길이는 " << str1.size() << "입니다." << endl;
    cout << "문자열 str2의 길이는 " << str2.length() << "입니다."   << endl;
    cout << "문자열 str2의 길이는 " << str2.size() << "입니다."   << endl;

    //문자 추가
    str1.append("C++ Programming");
    str2.append("C++ Programming", 4, 7);
    str3.append(4, 'X');
    cout << str1 << endl;
    cout << str2 << endl;
    cout << str3 << endl;

    //특정 문자 찾기
    str = "C++ Programming";
    cout << str.find("Pro") << endl;
    cout << str.find('r') << endl;

    if (str.find("Pro", 5) != string::npos)
    {
        cout << "해당 문자열을 찾았습니다." << endl;
    }
    else
    {
        cout << "해당 문자열을 찾지 못했습니다." << endl;
    }

        if (str.find("r", 5) != string::npos)
    {
        cout << "해당 문자열을 찾았습니다." << endl;
    }
    else
    {
        cout << "해당 문자열을 찾지 못했습니다." << endl;
    }

    // 메소드는 특정 문자열을 찾아, 그 문자열을 다른 문자열로 대체
    string str4 = "C++ is very nice!";
    string str5 = "nice";
    string str6 = "awesome";
    string::size_type index = str4.find(str5);
    if (index != string::npos)
    {
        str4.replace(index, str5.length(), str6);
    }
    cout << str4<< endl;

    //capacity() 메소드와 max_size() 메소드
    str = "C++ Programming";
    cout << "문자열 str의 length는 " << str.length() << "입니다." << endl;
    cout << "문자열 str의 capacity는 " << str.capacity() << "입니다." << endl;
    cout << "문자열 str의 max_size는 " << str.max_size() << "입니다.";



}