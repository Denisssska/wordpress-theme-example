// const menuItems = document.querySelectorAll('.menu-item');
// const alternativeFunctionClick =function (){
//     menuItems.forEach(item=>item.classList.forEach(el=>{
//         if(el==="active"){
//             item.addEventListener('click',(e)=>{
//                 e.target.classList.remove("active")
//             })
//         }
//     }))
//
//
// };
//     menuItems.forEach(item=>item.classList.forEach(el=>el==="active"?item.addEventListener('click',(e)=>{
//         e.target.classList.remove("active")
//
//         }):
//         item.addEventListener('click',(e)=>{
//             e.target.classList.add("active")
//             alternativeFunctionClick()
//         }) ));

const menuItems = document.querySelector('.button-large');
// Example POST method implementation:
// async function postData(url, data) {
//     // Default options are marked with *
//     const response = await fetch(url, {
//         method: "POST", // *GET, POST, PUT, DELETE, etc.
//         mode: "cors", // no-cors, *cors, same-origin
//         cache: "no-cache", // *default, no-cache, reload, force-cache, only-if-cached
//         credentials: "same-origin", // include, *same-origin, omit
//         headers: {
//             "Content-Type": "application/json",
//             // 'Content-Type': 'application/x-www-form-urlencoded',
//         },
//         redirect: "follow", // manual, *follow, error
//         referrerPolicy: "no-referrer", // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
//         body: JSON.stringify(data), // body data type must match "Content-Type" header
//     });
//     return response.json(); // parses JSON response into native JavaScript objects
// }
const content =
    [
        'comment_ID',
        'comment_post_ID',
        'comment_author',
        'comment_author_email',
        'comment_author_url',
        'comment_author_IP',
        'comment_date',
        'comment_date_gmt',
        'comment_content',
        'comment_karma',
        'comment_approved',
        'comment_agent',
        'comment_type',
        'comment_parent',
        '2',
    ];
const string = content.join(',');
// Default options are marked with *

// const request = async (method, payload) => {
//     try {
//         const res = await fetch("http://elkin-les/wp-json/den/new-comment", {
//             method,
//             headers: {
//                 // 'X-WP-Nonce': data.nonce,
//                 'Content-Type': 'application/json'
//             },
//             body: JSON.stringify(payload)
//         });
//         return await res.json();
//
//     } catch (e) {
//         return e;
//     }
// };


menuItems && menuItems.addEventListener('click', () => {
    console.log("single click")
  //  request('POST', string).then(r => console.log(r))
// fetch('http://elkin-les/wp-json/den/all-posts').then(r =>r.json()).then(r=>console.log(r));
fetch('http://elkin-les/wp-json/den/all-comments').then(r =>r.json()).then(r=>console.log(r));
});


//примеры задач на собес
// const array1 = ['a', 'b', 'c'];
//
// for (const element of array1) {
//     console.log(element);
// }

// const iterable = new Map([
//     ["a", 1],
//     ["b", 2],
//     ["c", 3],
// ]);
//
// for (const entry of iterable) {
//     console.log(entry);
// }
// // ['a', 1]
// // ['b', 2]
// // ['c', 3]
//
// for (const [key, value] of iterable) {
//     console.log(value);
//     console.log(key);
// }
// // 1
// // 2
// // 3
// Object.prototype.objCustom = function () {};
// Array.prototype.arrCustom = function () {};
//
// const iterable = [3, 5, 7];
// iterable.foo = "hello";
//
// for (const i in iterable) {
//     console.log(i);
// }

///// функция которая принимает обьект  и возвращает значение на основе пути
// function get(obj, path, defaultValue) {
//     const keys = path.split(".");
//     const go = (acc, v) => (acc === undefined) ? acc : acc[v];
//     const res = keys.reduce(go, obj);
//     return (res === undefined) ? defaultValue : res;
// }
//
// const obj = {
//     a: {
//         b: {
//             c: 'd'
//         },
//         e: 'f'
//     }
// };
// console.log(get(obj, 'a.b'))
// console.log(get(obj, 'a.x.e'))

////// частичное суммирование через reduce
// const  arr = [ 1, 2, 3, 4, 5 ];
// const getSums = (arr)=>{
//     let newArr = [];
//     if (!arr.length) return newArr;
//        let res = arr.reduce(function (sum,current) {
//           newArr.push(sum + current)
//            return sum + current
//         },0)
//     return newArr
// }
// console.log(getSums([-2,-1,0,1]))
