## Factory

* 팩토리 메서드 패턴(Factory Method Pattern)
  * 객체를 생성하는 인터페이스는 미리 정의하되, 인스턴스를 만들 클래스의 결정은 서브(자식) 클래스 쪽에서 내리는 패턴
    ```js
    function HamPizza() {
        let price = 10000;
        this.getPrice = function() {
            return price;
        }
    }
    
    function SeafoodPizza() {
        let price = 20000;
        this.getPrice = function() {
            return price;
        }
    }

    function CheesePizza() {
        let price = 15000;
        this.getPrice = function() {
            return price;
        }
    }

    function PizzaFactory() {
        this.createPizza = function(type) {
            switch(type) {
                case "Ham" : 
                    return new HamPizza();
                case "Seafood" : 
                    return new SeafoodPizza();
                case "Cheese" : 
                    return new CheesePizza();
                default :
                    return new HamPizza();
            }
        }
    }

    const pizzaPrice = new PizzaFactory().createPizza("Seafood").getPrice();
    console.log(pizzaPrice); // 20000

    =================================

    function coffeeFactory(type) { // type을 받아서 생성
        let coffee;

        if(type === 'latte') coffee = new Latte();
        else if(type === 'mocha') coffee = new Mocah();
        else if(type === 'americano') coffee = new Americano();
    }
    ```
  * 장점
    * 객체들을 한 곳에서 관리할 수 있음 ( factory에서 관리 )
    * 동일한 인터페이스에서 구현이 되므로 새로운 클래스가 추가되거나 확장되어도 새로운 하위 클래스를 만들면 되기 때문에 확장성이 용이함
    * 메소드로 동작하기 때문에 리턴 값을 가질 수 있음 ( 리턴 값으로 상황에 따라 서로 다른 객체를 반환 할 수 있음 , 유연함 )
  * 단점
    * 객체가 늘어날 때마다 하위 클래스 재정의로 인한 불필요한 많은 클래스 생성 가능성 있음
---
## Class

* 자바스크립트에서 클래스를 만드는 3가지 방법 
  * 리터럴 방식
    ```js
    const 인스턴스 = {
        프로터피1 : 초기값,
        프로퍼티2 : 초기값,
        메서드1 : function() {

        },
        메서드2 : function() {

        }
    }

    ============

    const userName = 'jin';
    const userAge = 26; 

    const user = {
        userName,
        userAge,

        setUserName(userName) {
            this.userName = userName;
            return this;
        }
    };

    console.log(user.setUserName('jjinii').userName); //jjinii
    ```
  * 함수 방식
    ```js
    function 클래스이름() {
        this.프로퍼티1 = 초기값; // 프로퍼리 >> 멤버 변수
        this.프로퍼티2 = 초기값;

        this.메서드1 = function() { // 메서드 >> 멤버 함수

        }
        this.메서드2 = function() {

        }
    }
    const 인스턴스 = new 클래스이름(); // 인스턴스 >> 객체  // 객체 생성 시 new 키워드를 사용
    // 단점 : 인스턴스를 생성할 때마다 내부의 모든 메서드가 독립적으로 만들어진다는 것
    ```
  * 프로토타입 방식
    ```js
    function 클래스이름() {
        this.프로퍼티1 = 초기값;
        this.프로퍼티2 = 초기값;
    }
    클래스이름.prototype.메서드1 = function() {

    }
    클래스이름.prototype.메서드2 = function() {

    }
    ```
    * 참고 : https://webclub.tistory.com/136
  
* 생성자(constructor) :  class 로 생성된 객체를 생성하고 초기화하기 위한 메소드
  *  클래스 안에 한 개만 존재 가능 ( 여러 개의 constructor 메소드가 존재하면 SyntaxError 가 발생 )
* extends : 부모 클래스 상속받는 자식 클래스를 정의할 때 사용.
* super : 부모 클래스를 참조 할 때 , 또는 부모 클래스의 constructor을 호출 할 때 사용.


```js
// 클래스 선언
class Vehicle {
    constructor (wheel, model, color) { // constructor 메소드
        this.wheel = wheel;
        this.model = model;
        this.color = color;
    }  
    getName() {
        return this.wheel + " " + this.model;
    }
}

class Car extends Vehicle{
    getName() {
    //    return this.wheel + " / " + this.model;
    return super.getName();
    }
}

// constructor  >> new 키워드 필요
const car = new Car("Circle", "BMW", "Black");

// 이 때 부모의 getName 을 불러오려면 >> super
console.log(car.getName()) // Circle / BMW (자식 getName)

==============================

let Rectangle = class { // 클래스 이름이 없는 표현식
    constructor(height, width) {
        this.height = height;
        this.width = width;
    }
    calcArea() {
        return this.height * this.width;
    }
    get area() {
        return this.calcArea();
    }
}
```
* 참고  : https://developer.mozilla.org/ko/docs/Web/JavaScript/Reference/Classes
---
## New, constructor, instanceof, instance
* new 연산자 : 사용자 정의 객체 타입 또는 내장 객체 타입의 인스턴스를 생성
* instanceof 연산자 : 생성자의 prototype 속성이 객체의 프로토타입 체인 어딘가 존재하는지 판별

```js
// 생성자(constructor) 함수가 new 연산자를 만나면 instance를 생성.
function Rectangle(height, width) { // constructor
  this.height = height;
  this.width = width;
}

const square = new Rectangle(50,15); // instance 생성(객체 생성)

console.log(square.height);
console.log(square.width);
console.log(square instanceof Rectangle) // true
```
