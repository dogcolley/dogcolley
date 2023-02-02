//this의 개념과 스코프의 개념은 많이 비슷하다. 

var myProsess = {
    name : '',
    phone : '',
    setName : (setName) =>{
        this.name = setName;
    },
    sayName : () =>{
        console.log(this.name);
    },
    axiosing : () =>{
        console.log(this);
        const userinfo = this;
        axios().then(()=>{
            console.log(this);
        });
    }
}

function axios(){
    console.log(this);
}


myProsess.setName('개밥');
myProsess.sayName();
myProsess.axiosing();
