import * as fs from 'fs/promises';
import * as path from 'path';
import { DayResultInterface } from './day-result.interface';

class Day01 implements DayResultInterface {

    // Chemin du fichier d'input permettant de résoudre l'énigme du jour
    private filePath :string = path.join(__dirname, '../data/input_01.txt');
    private list1 :number[] = [];
    private list2 :number[] = [];

    private async initializeList(): Promise<boolean> {

        if (this.list1.length > 0 && this.list2.length > 0) {
            return true;
        }

        return fs.readFile(this.filePath, 'utf8').then(data => {
            const lines :string[] = data.split('\n');

            this.list1 = lines.map((value :string, index :number) :number => {
                let values :string[] = value.split('   ');
                this.list2[index] = Number(values.slice(-1));
                return Number(values.shift());
            });

            this.list1.sort();
            this.list2.sort();

            return true;
        });
    }

    public async resultStar1(): Promise<number> {

        await this.initializeList();

        // Implémentation pour la première étoile du jour 01
        return this.list1.map((list1Value:number, index:number):number => {
            let list2Value:number = this.list2[index];
            return Math.abs(list1Value - list2Value);
        }).reduce((acc:number, distance:number):number => acc + distance);
    }

    public async resultStar2(): Promise<number> {

        await this.initializeList();

        // Implémentation pour la deuxième étoile du jour 01
        // similitary score
        return this.list1.map((list1Value:number):number => {
            let similarity:number = this.list2.filter((list2Value:number):boolean => list2Value === list1Value).length;
            return Math.abs(list1Value * similarity);
        }).reduce((acc:number, distance:number):number => acc + distance);
    }
}

(async () => {
    try {
        const day01 :Day01 = new Day01();
        console.log('star1 :', await day01.resultStar1()) ;
        console.log('star2 :', await day01.resultStar2()) ;
    } catch (erreur) {
        console.error('Erreur :', erreur);
    }
})();





