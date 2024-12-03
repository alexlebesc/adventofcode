import * as fs from 'fs/promises';
import * as path from 'path';
import { DayResultInterface } from './day-result.interface';

class Day11 implements DayResultInterface {

    // Chemin du fichier d'input permettant de résoudre l'énigme du jour
    private filePath :string = path.join(__dirname, '../data/input_11.txt');

    private async initializeList(): Promise<boolean> {

        return fs.readFile(this.filePath, 'utf8').then(data => {
            const lines :string[] = data.split('\n');

            return true;
        });
    }

    public async resultStar1(): Promise<number> {

        await this.initializeList();

        // Implémentation pour la première étoile du jour 11
        return 0;
    }

    public async resultStar2(): Promise<number> {

        await this.initializeList();

        // Implémentation pour la deuxième étoile du jour 11 

        return 0;
    }
}

(async () => {
    try {
        const day11:Day11 = new Day11();
        console.log('star1 :', await day11.resultStar1()) ;
        console.log('star2 :', await day11.resultStar2()) ;
    } catch (erreur) {
        console.error('Erreur :', erreur);
    }
})();

