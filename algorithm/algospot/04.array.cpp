#include <iostream>
#include <stdio.h>
using namespace std;

int main(){
    int sum = 0;
    int grade[3];  // 길이가 3인 int형 배열 선언
                   // 인덱스를 이용한 배열의 초기화
    grade[0] = 85; // 국어 점수
    grade[1] = 65; // 영어 점수
    grade[2] = 90; // 수학 점수
    for (int i = 0; i < 3; i++)
    {
        sum += grade[i]; // 인덱스를 이용한 배열로의 접근
    }
    cout << "국영수 과목 총 점수 합계는 " << sum << "점이고, 평균 점수는 " << (double)sum/3 <<"점입니다." << endl; 

    int grade2[] = {85, 65, 90};                 // 배열의 길이를 명시하지 않음
    int len = sizeof(grade2) / sizeof(grade[0]); // 배열의 길이를 구하는 공식
    cout << "배열 grade의 길이는 " << len << "입니다." << endl;

    int arr1[6] = {10, 20, 30, 40, 50, 60};
    int arr2[2][3] = {10, 20, 30, 40, 50, 60};

    int arr_col_len = sizeof(arr2[0]) / sizeof(arr2[0][0]); 
    int arr_row_len = (sizeof(arr2) / arr_col_len) / sizeof(arr2[0][0]);

    cout << "배열 arr1 길이는 " << arr_col_len << "입니다." << endl;
    cout << "배열 arr1 길이는 " << arr_row_len << "입니다." << endl;


}