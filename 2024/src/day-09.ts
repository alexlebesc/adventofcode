import * as fs from 'fs/promises';
import * as path from 'path';
import { DayResultInterface } from './day-result.interface';

class Day09 implements DayResultInterface {

    // Chemin du fichier d'input permettant de résoudre l'énigme du jour
    private filePath :string = path.join(__dirname, '../data/input_09.txt');
    private diskMap :number[] = [];

    private async initializeList(): Promise<boolean> {

        return fs.readFile(this.filePath, 'utf8').then(data => {
            this.diskMap = data.split('').map(Number);

            return true;
        });
    }

    private compactFile(diskMap :number[]) : number[]
    {
        const disk :string[] = [];
        const compactedFile :number[] = [];
        let fileId = 0;
        diskMap.forEach((nbSpace, index) => {
            if ((index % 2) === 0) {
                for (let i = 0; i < nbSpace; i++) {
                    disk.push(fileId.toString());
                }
                fileId = fileId + 1;
                return;
            }

            for (let i = 0; i < nbSpace; i++) {
                disk.push('.');
            }
        });

        // count the number of free space
        let spaceToMove = disk.length - 1;
        const nbBlockFile = disk.filter((space) => space !== '.').length;
        for (let i = 0; i < nbBlockFile; i++) {
            if (disk[i] !== '.') {
                compactedFile.push(parseInt(disk[i]));
                continue;
            }

            if (disk[i] === '.') {
                while(disk[spaceToMove] === '.') {
                    spaceToMove = spaceToMove - 1;
                }
                compactedFile.push(parseInt(disk[spaceToMove]));
                disk[spaceToMove] = '.';
            }
            //this.display(compactedFile);
        }

        return compactedFile;
    }

    private display(compactedFile:number[]): void
    {
        console.log(compactedFile.join(''));
    }

    private computeChecksum(compactedFile :number[]): number
    {
        return compactedFile.reduce((checksum, id, position) => checksum + (id * position), 0);
    }

    public async resultStar1(): Promise<number> {

        await this.initializeList();

        // Implémentation pour la première étoile du jour 09
        const compactedFile = this.compactFile(this.diskMap);
        return this.computeChecksum(compactedFile);
    }

    public async resultStar2(): Promise<number> {

        await this.initializeList();

        // Implémentation pour la deuxième étoile du jour 09 

        return 0;
    }
}

(async () => {
    try {
        const day09:Day09 = new Day09();
        console.log('star1 :', await day09.resultStar1()) ;
        console.log('star2 :', await day09.resultStar2()) ;
    } catch (erreur) {
        console.error('Erreur :', erreur);
    }
})();

