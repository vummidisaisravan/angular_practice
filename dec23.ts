//all files code added here
// math.ts
export const add = (a: number, b: number): number => a + b;
export const subtract = (a: number, b: number): number => a - b;
// main.ts
//impoting add and subtract from math.ts


import { add, subtract } from './math';
console.log(add(2, 3)); // Output: 5
console.log(subtract(5, 3)); // Output: 2


//impoting all from math.ts
import * as MathUtils from './math';
console.log(MathUtils.add(1, 2)); // Output: 3

// module behavior in the tsconfig.json
{
    "compilerOptions": {
      "module": "es6"
    }
  }

//class decorator
  function AddMetadata(metadata: string) {
    return function (constructor: Function) {
        constructor.prototype.metadata = metadata;
    };
}

// Decorate the class with metadata
@AddMetadata('This is a Person class.')
class Person {
    constructor(public name: string, public age: number) {}
}

// Access metadata
const person = new Person('Bob', 30);
console.log((person as any).metadata); // Output: "This is a Person class."