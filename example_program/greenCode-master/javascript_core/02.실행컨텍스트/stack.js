class Node {
    constructor(value){
      this.value = value;
      this.next = null;
    }
  }
  
  class Stack {
    constructor(){
      this.top = null;
      this.bottom = null;
      this.length = 0;
    }
    peek() {
      // stack에 쌓인 가장 마지막 녀석을 확인하는 메소드
      return this.top;
    }
    push(value){
      const newNode = new Node(value);
      
      if (this.length === 0) {
        this.top = newNode;
        this.bottom = newNode;
      } else {
        const holdingPointer = this.top;
        this.top = newNode;
        this.top.next = holdingPointer;
      }
      this.length++;
      return this;
    }
    pop(){
      if (!this.top) return null;
      if (this.top === this.bottom) {
        this.bottom = null;
      }
      this.top = this.top.next;
      this.length--;
      return this;
    }
    //isEmpty
  }
  
  const myStack = new Stack();
  console.log(myStack);
  myStack.peek();
  console.log(myStack);
  myStack.push('google');
  console.log(myStack);
  myStack.push('facebook');
  console.log(myStack);
  myStack.push('udemy');
  console.log(myStack);
  myStack.pop();
  console.log(myStack);
  myStack.pop();
  console.log(myStack);
  myStack.pop();
  console.log(myStack);