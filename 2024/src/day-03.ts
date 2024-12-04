import * as fs from 'fs/promises';
import * as path from 'path';
import { DayResultInterface } from './day-result.interface';

/**
 * --- Day 3: Mull It Over ---
 * "Our computers are having issues, so I have no idea if we have any Chief Historians in stock!
 * You're welcome to check the warehouse, though," says the mildly flustered shopkeeper at the North Pole Toboggan Rental Shop.
 * The Historians head out to take a look.
 *
 * The shopkeeper turns to you. "Any chance you can see why our computers are having issues again?"
 *
 * The computer appears to be trying to run a program, but its memory (your puzzle input) is corrupted.
 * All of the instructions have been jumbled up!
 *
 * It seems like the goal of the program is just to multiply some numbers.
 * It does that with instructions like mul(X,Y), where X and Y are each 1-3 digit numbers.
 * For instance, mul(44,46) multiplies 44 by 46 to get a result of 2024. Similarly, mul(123,4) would multiply 123 by 4.
 *
 * However, because the program's memory has been corrupted,
 * there are also many invalid characters that should be ignored,
 * even if they look like part of a mul instruction.
 * Sequences like mul(4*, mul(6,9!, ?(12,34), or mul ( 2 , 4 ) do nothing.
 *
 * For example, consider the following section of corrupted memory:
 *
 * xmul(2,4)%&mul[3,7]!@^do_not_mul(5,5)+mul(32,64]then(mul(11,8)mul(8,5))
 * Only the four highlighted sections are real mul instructions.
 * Adding up the result of each instruction produces 161 (2*4 + 5*5 + 11*8 + 8*5).
 *
 * Scan the corrupted memory for uncorrupted mul instructions.
 * What do you get if you add up all of the results of the multiplications?
 */
class Day03 implements DayResultInterface {

    // Chemin du fichier d'input permettant de résoudre l'énigme du jour
    private filePath :string = path.join(__dirname, '../data/input_03.txt');
    private multiplication :string[][] = [];

    private async initializeList1(): Promise<boolean> {
        this.multiplication = [];

        return fs.readFile(this.filePath, 'utf8').then(data => {
            const lines :string[] = data.split('\n');

            lines.forEach((line) => {
                this.extractMultiplication(line);
            });
            return true;
        });
    }

    private async initializeList2(): Promise<boolean> {
        this.multiplication = [];

        return fs.readFile(this.filePath, 'utf8').then(data => {

            const dontlines = data.split('don\'t');

            let firstLine = dontlines.shift() ?? '';
            this.extractMultiplication(firstLine);

            dontlines.forEach((dontline) => {
                let dolines = dontline.split('do');
                dolines.shift();
                dolines.forEach((doline) => {
                    this.extractMultiplication(doline);
                });
            });
            return true;
        });
    }

    private extractMultiplication(line :string) :void
    {
        const regex = /mul\(([0-9]{1,3}),([0-9]{1,3})\)/g;
        const matches = [...line.matchAll(regex)];
        const result :string[][] = matches.map(match => [match[1], match[2]]);
        this.multiplication = this.multiplication.concat(result);
    }

    public async resultStar1(): Promise<number> {

        await this.initializeList1();

        // Implémentation pour la première étoile du jour 03
        return this.multiplication.map(
            (mul :string[]) :number => Number(mul[0]) * Number(mul[1])
        ).reduce(
            (total, value) => total + value,
            0
        );
    }

    public async resultStar2(): Promise<number> {

        await this.initializeList2();

        // Implémentation pour la deuxième étoile du jour 03 
        return this.multiplication.map(
            (mul :string[]) :number => Number(mul[0]) * Number(mul[1])
        ).reduce(
            (total, value) => total + value,
            0
        );
    }
}

(async () => {
    try {
        const day03:Day03 = new Day03();
        console.log('star1 :', await day03.resultStar1()) ;
        console.log('star2 :', await day03.resultStar2()) ;
    } catch (erreur) {
        console.error('Erreur :', erreur);
    }
})();

