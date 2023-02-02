var a = 3 ; //전역선언

function outer (){
    console.log(a) // 값:3 클로저
    function inner(){
        console.log(a); // 값은 언디파인드 이유는 호이스팅
        var a = 2;
        console.log(this); //여기서는 전역을 호출한다.
        console.log(inner); //여기서는 스콥이 연결된 상태의 inner를 확인할수 있다.
    }
    inner();
    console.log(a) //값:3
}

outer();

console.log(a); // 3 스냅샷