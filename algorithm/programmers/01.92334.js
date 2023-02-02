function solution(id_list, report, k) {
    const answer = [];
    let id_obj = {};
    let id_obj_cnt = {};


    for(let i = 0 ; i < id_list.length; i++){
        const name = id_list[i];
        eval(`id_obj.${name} = [];`);
        eval(`id_obj_cnt.${name} = 0;`);
        answer.push(0)
    }

    for(let j = 0 ; j < report.length; j++){
        const arr = report[j].split(" ");
        const singoja = arr[0]
        const singoin = arr[1]

        if(eval(`id_obj.${singoin}.indexOf('${singoja}')`) == -1){
            eval(`id_obj.${singoin}.push('${singoja}')`);
        }
    }

    for (const key in id_obj) {
        const obj = eval(`id_obj.${key}`);
        if(obj.length >= k){
            for(let i = 0 ; i < obj.length ; i++){
                eval(`id_obj_cnt.${obj[i]}++`);
            }
        }
    }

    let i = 0;
    for (const key in id_obj_cnt) {
        answer[i] = eval(`id_obj_cnt.${key}`);
        i++;
    }

    return answer;
}


const a = solution(
    ["muzi", "frodo", "apeach", "neo"], ["muzi frodo", "apeach frodo", "frodo neo", "muzi neo", "apeach muzi"], 2
)

console.log(a)