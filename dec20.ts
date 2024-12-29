class DataContainer<T> {
    private items: T[] = [];

    addItem(item: T): void {
        this.items.push(item);
    }

    findItem(itemToFind: T): T | null {
        const found = this.items.find((item) => item === itemToFind);
        return found !== undefined ? found : null;
    }

    getAllItems(): T[] {
        return [...this.items];
    }
}

const container = new DataContainer<number>();
container.addItem(10);
container.addItem(20);
container.addItem(30);


const foundItem = container.findItem(20);
console.log(foundItem); // Output: 20
