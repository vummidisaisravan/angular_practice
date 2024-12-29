//method decorator
function LogMethod(target: Object, propertyKey: string, descriptor: PropertyDescriptor) {
    const originalMethod = descriptor.value;

    // Modify the method
    descriptor.value = function (...args: any[]) {
        console.log(`Method "${propertyKey}" was called with arguments:`, args);

        // Call the original method and store the result
        const result = originalMethod.apply(this, args);

        console.log(`Method "${propertyKey}" returned:`, result);
        return result;
    };
}

class Calculator {
    @LogMethod
    add(a: number, b: number): number {
        return a + b;
    }

    @LogMethod
    multiply(a: number, b: number): number {
        return a * b;
    }
}

const calc = new Calculator();
calc.add(5, 3);        // Logs method call and result
calc.multiply(4, 2);   // Logs method call and result

//output
// Method "add" was called with arguments: [ 5, 3 ]
// Method "add" returned: 8
// Method "multiply" was called with arguments: [ 4, 2 ]
// Method "multiply" returned: 8

//method decorator

function ToUpperCase(target: Object, propertyKey: string) {
    let value: string;

    Object.defineProperty(target, propertyKey, {
        get() {
            return value;
        },
        set(newValue: any) {
            value = typeof newValue === 'string' ? newValue.toUpperCase() : newValue;
        },
    });
}

// Example usage
class Product {
    @ToUpperCase
    name: string;
}

const product = new Product();
product.name = 'laptop';
console.log(product.name); // Output: LAPTOP

