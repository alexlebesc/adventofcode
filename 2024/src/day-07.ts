import * as fs from 'fs/promises';
import * as path from 'path';
import { DayResultInterface } from './day-result.interface';

class Day07 implements DayResultInterface {

    // Chemin du fichier d'input permettant de résoudre l'énigme du jour
    private filePath :string = path.join(__dirname, '../data/input_07.txt');
    private inputEquations :string[] = [];


    private async initializeList(): Promise<boolean> {

        return fs.readFile(this.filePath, 'utf8').then(data => {
            this.inputEquations = data.split('\n');

            return true;
        });
    }

    private findRightEquations(
        equations :string[],
        callback :(equation :string, members :number[], result :number, rightEquations :string []) => void
    ): string[]
    {
        const rightEquations :string[] = [];

        equations.forEach((equation :string) => {
            const [resultString, membersString] = equation.split(':');
            const members = membersString.trim().split(' ').map(Number);
            const result = parseInt(resultString);

            callback(equation, members, result, rightEquations);
        });

        return rightEquations;
    }

    private plusAndMultiply(equation :string, members :number[], result :number, rightEquations :string []) :void {

        // nbOperators
        const nbOperators = (members.length - 1);
        const operatorCombinations = [];
        const nbOperatorCombination = parseInt('1'.padEnd(nbOperators, '11'), 2);

        for (let i = 0 ; i <= nbOperatorCombination; i++) {
            // operatorCombinations.push(''+i.toString(2).padEnd(nbOperators, '0'));
            operatorCombinations.push(i.toString(2).padStart(nbOperators, '0'));
        }

        if (operatorCombinations.some((operatorCombination) => {
            const total = members.reduce((previousMember, member, index) => {
                const operator = operatorCombination[index -1];
                if (operator !== '0' && operator !== '1') {
                    throw 'pas d\'operateur';
                }

                if (operator == '0' ) {
                    return previousMember + member;
                }

                return previousMember * member;
            });

            return (result === total);
        })) {
            rightEquations.push(equation);
        }
    }

    private plusAndMultiplyAndConcat(equation :string, members :number[], result :number, rightEquations :string []) :void {

        // nbOperators
        const membersString :string[] = members.map(num => num.toString());
        const nbOperators :number = (members.length - 1);
        const operatorCombinations = [];
        const nbOperatorCombination = parseInt('2'.padEnd(nbOperators, '22'), 3);

        for (let i = 0 ; i <= nbOperatorCombination; i++) {
            operatorCombinations.push(i.toString(3).padStart(nbOperators, '0'));
        }

        const combinationsWithConcat = operatorCombinations.filter(
            (combination) => combination.includes('2')
        );


        if (combinationsWithConcat.some((operatorCombination) => {
            const total = members.reduce((previousMember, member, index) => {
                const operator = operatorCombination[index -1];
                if (operator !== '0' && operator !== '1' && operator !== '2') {
                    throw 'pas d\'operateur';
                }

                if (operator == '0' ) {
                    return previousMember + member;
                }

                if (operator == '1' ) {
                    return previousMember * member;
                }

                return parseInt(previousMember.toString().concat(member.toString()));
            });

            return (result === total);
        })) {
            rightEquations.push(equation);
        }
    }

    private computeResultOfEquations(equations :string[]) : number
    {
        return equations.map((equation) => {
            const [resultString,] = equation.split(':');
            return parseInt(resultString ?? 0);
        }).reduce((total, result) => total + result, 0)
    }

    public async resultStar1(): Promise<number> {

        await this.initializeList();

        // Implémentation pour la première étoile du jour 07
        return this.computeResultOfEquations(this.findRightEquations(this.inputEquations, this.plusAndMultiply));
    }

    public async resultStar2(): Promise<number> {

        await this.initializeList();

        // Implémentation pour la deuxième étoile du jour 07
        const rightEquations = this.findRightEquations(this.inputEquations, this.plusAndMultiply);
        const wrongEquations = this.inputEquations.filter((equation) => !rightEquations.includes(equation));
        const rightEquationsWithConcat =  this.findRightEquations(wrongEquations, this.plusAndMultiplyAndConcat);
        return this.computeResultOfEquations([...rightEquations, ...rightEquationsWithConcat]);

    }
}

(async () => {
    try {
        const day07:Day07 = new Day07();
        console.log('star1 :', await day07.resultStar1()) ;
        console.log('star2 :', await day07.resultStar2()) ;
    } catch (erreur) {
        console.error('Erreur :', erreur);
    }
})();

