#include <iostream>
using namespace std;

int main(){
    int num =5;
    if (num < 5)
    {
        cout << "입력하신 수는 5보다 작습니다." << endl;
    }

    else if (num == 5)
    {
        cout << "입력하신 수는 5입니다." << endl;
    }

    else if (num > 5)
    {
        cout << "입력하신 수는 5보다 큽니다." << endl;
    }

    else 
    {
        cout << "숫자를 입력해주시겠어요?" << endl;
    }


    switch (num)
    {
        case 1:
            cout << "입력하신 수는 1입니다." << endl;
            break;

        case 2:
            cout << "입력하신 수는 2입니다." << endl;
            break;

        case 3:
            cout << "입력하신 수는 3입니다." << endl;
            break;

        case 4:
            cout << "입력하신 수는 4입니다." << endl;
            break;

        case 5:
            cout << "입력하신 수는 5입니다." << endl;
            break;

        default:
            cout << "1부터 5까지의 수만 입력해 주세요!" << endl;
            break;
    }

    char ch = 'C';
	switch (ch)
	{
		case 'a':
		case 'A':
			cout << "이 학생의 학점은 A입니다." << endl;
			break;
		case 'b':
		case 'B':
			cout << "이 학생의 학점은 B입니다." << endl;
			break;
		case 'c':
		case 'C':
			cout << "이 학생의 학점은 C입니다." << endl;
			break;
		case 'd':
		case 'D':
			cout << "이 학생의 학점은 D입니다." << endl;
			break;
		case 'f':
		case 'F':
			cout << "이 학생의 학점은 F입니다." << endl;
			break;
		default:
			cout << "학점을 정확히 입력해 주세요!(A, B, C, D, F)" << endl;
			break;
	}

    int cnt = 0;
    while (cnt < num)
    {
        cout << "while 문이 현재 " << cnt + 1 << " 번째 반복 실행중입니다." << endl;
        cnt++; // 이 부분을 삭제하면 무한 루프에 빠지게 됨
    }
    cout << "while 문이 종료된 후 변수 i의 값은 " << cnt << "입니다." << endl;

    int except_num = 2;
    for (int i = 0; i <= 100; i++)
    {
        if (i % except_num == 0)
        {
            continue;
        }
        cout << i << " ";
    }

}