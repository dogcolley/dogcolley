### 콜백 함수
- - -
+ # 콜백 함수

    + 다른 코드에 인자로 넘겨줌으로써 제어권도 함께 위임한 함수
        + 제어권을 넘겨받은 코드는 콜백 함수를 호출하는 시점을 스스로 판단해서 실행
        
```javascript
let count = 0;
let cbFunc = function () {
    console.log(count);
        if (++count > 4) clearInterval(timer);
};
let timer = setInterval(cbFunc, 300)
```
        
    + 콜백 함수를 사용하다보면, 콜백 지옥에 빠지기 쉬움
        + 콜백 함수가 다시 콜백 함수를 호출하는 과정이 반복되면서, 코드의 가독성이 떨어지며 관리가 힘들어짐
                
+ # 콜백함수 this

+ 콜백 함수도 함수이기 때문에, 기본적으로 this가 전역 객체를 참조
        + bind를 이용해서 콜백함수 this 바인딩 가능
            
```javascript
let obj1 = {
    name : "obj1",
    func : function() {
        console.log(this.name);
        }
}

setTimeout(obj1.func.bind(obj1),1000); // obj1
let obj2 = {name : "obj2"};
setTimeout(obj1.func.bind(obj2),1500); // obj2
```
- - - 
+ # Promise ( ES6 )

    + 비동기식 처리를 동기식 처럼 처리하기 위해 도입
        + 동기식 : 현재 실행 중인 코드가 완료된 후에야 다음 코드를 실행
        + 비동기식 : 현재 실행 중인 코드의 완료 여부와 상관 없이 다음 코드를 실행
            + "별도의 요청, 실행 대기, 보류" 등과 관련 됨
    
    + new Promise(excutor)
        + Promise의 인자로 넘겨주는 콜백 함수 내부에 "resolve()" or "reject()" 함수를 호출하는 구문이 있는 경우
        + 둘 중 하나의 함수가 실행되기 전까지는 "then" 또는 "catch" 구문으로 넘어가지 않음
            + 비동기식 처리의 동기식 처리화

```javascript
function devide(numA, numB) {
    return new Promise((resolve, reject) => {
        if (numB === 0) reject(new Error("Unable to devide by 0."))
        else resolve(numA / numB)
    })
}

devide(4,0)
    .then((result) => console.log("성공 : ", result))
    .catch((error) => console.log("실패 : ", error))
```


-----------------
+ 참고 사이트
    + [Promise 관련](https://www.daleseo.com/js-async-callback/)
    + [Generator](https://velog.io/@rohkorea86/Generator-함수를-이해해보자-이론편-2.-어디에-제네레이터-함수를-써야-하는가-제네레이터-함수는-무엇)
