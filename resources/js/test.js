//==> Array Push : Add a new item to an array
// const fruits = ["Banana", "Orange", "Apple", "Mango"];
// fruits.push("Kiwi");
// console.log(fruits);
// result = [ 'Banana', 'Orange', 'Apple', 'Mango', 'Kiwi' ];


//==> Array Pop : Remove the last item of an array
// const fruits = ["Banana", "Orange", "Apple", "Mango"];
// fruits.pop();
// console.log(fruits);
// result = [ 'Banana', 'Orange', 'Apple' ];


//==> Array Shift : Remove the first item of an array
// const fruits = ["Banana", "Orange", "Apple", "Mango"];
// fruits.shift();
// console.log(fruits);
// result = [ 'Orange', 'Apple', 'Mango' ];


//==> Array Unshift : Add a new item to the beginning of an array
// const fruits = ["Banana", "Orange", "Apple", "Mango"];
// fruits.unshift("Lemon");
// console.log(fruits);
// result = [ 'Lemon', 'Banana', 'Orange', 'Apple', 'Mango' ];


//==> Array Delete : Delete an element from an array
// const fruits = ["Banana", "Orange", "Apple", "Mango"];
// delete fruits[0];
// console.log(fruits)
// result = [ <1 empty item>, 'Orange', 'Apple', 'Mango' ]


//==> Array Splice : Add a new item to an array
// const fruits = ["Banana", "Orange", "Apple", "Mango"];
// fruits.splice(2, 0, "Lemon", "Kiwi");
// console.log(fruits)
// result = [ 'Banana', 'Orange', 'Lemon', 'Kiwi', 'Apple', 'Mango' ]


const arr = [1, 2, 3];
arr.forEach(element => console.log(element));
const doubled = arr.map(x => x * 2); // [2, 4, 6]
console.log(doubled);
const found = arr.find(x => x > 2); // 3
