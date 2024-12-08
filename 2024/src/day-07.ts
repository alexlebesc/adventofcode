import * as fs from 'fs/promises';
import * as path from 'path';
import { DayResultInterface } from './day-result.interface';

class Day07 implements DayResultInterface {

    // Chemin du fichier d'input permettant de résoudre l'énigme du jour
    private filePath :string = path.join(__dirname, '../data/input_07.txt');
    private equations :string[] = [];
    private wrongEquation :string[] = [];
    private rightEquationResult :number[] = [];



    private async initializeList(): Promise<boolean> {

        return fs.readFile(this.filePath, 'utf8').then(data => {
            this.equations = data.split('\n');

            return true;
        });
    }

    private findRightEquations(star2 :boolean = false): number[]
    {
        const rightEquationResult = this.rightEquationResult;

        if (this.rightEquationResult.length === 0) {
            this.equations.forEach((equation :string) => {
                const [resultString, membersString] = equation.split(':');
                const members = membersString.trim().split(' ').map(Number);
                const result = parseInt(resultString);

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
                    this.rightEquationResult.push(result);
                } else {
                    this.wrongEquation.push(equation);
                }
            });
        }

        if (star2) {
            this.wrongEquation.forEach((equation :string) => {
                const [resultString, membersString] = equation.split(':');
                const members = membersString.trim().split(' ').map(Number);
                const result = parseInt(resultString);

                // nbOperators
                const nbOperators = (members.length - 1);
                const operatorCombinations = [];
                const nbOperatorCombination = parseInt('2'.padEnd(nbOperators, '22'), 3);

                for (let i = 0 ; i <= nbOperatorCombination; i++) {
                    operatorCombinations.push(i.toString(3).padStart(nbOperators, '0'));
                }

                console.log('-------------------------- START --------');

                console.log(equation);
                console.log(members);
                console.log(result);

                if (operatorCombinations.some((operatorCombination) => {
                    let concatFirst = false;
                    const total = members.reduce((previousMember, member, index, allMembers) => {
                        const operator = operatorCombination[index -1];
                        const previousOperator = operatorCombination[index - 2] ?? 3;
                        const nextOperator = operatorCombination[index] ?? '3';
                        if (operator !== '0' && operator !== '1' && operator !== '2') {
                            throw 'pas d\'operateur';
                        }

                        if (operator == '0' && nextOperator != '2') {
                            return previousMember + member;
                        }

                        if (operator == '1' && nextOperator != '2') {
                            return previousMember * member;
                        }

                        if (!concatFirst) {
                            concatFirst = true;
                            return previousMember;
                        }

                        concatFirst = false;
                        const newConcatValue = parseInt(allMembers[index - 1].toString().concat(member.toString()));

                        if (previousOperator == '0') {
                            return previousMember + newConcatValue;
                        }

                        if (previousOperator == '1') {
                            return previousMember * newConcatValue;
                        }

                        return newConcatValue;
                    });

                    console.log(result, operatorCombination, total, (result === total));
                    return (result === total);
                })) {
                    console.log('-------------------------- ADDED --------');
                    this.rightEquationResult.push(result);
                }

                console.log('-------------------------- END --------');
            });
        }

        return this.rightEquationResult;
    }

    public async resultStar1(): Promise<number> {

        await this.initializeList();

        // Implémentation pour la première étoile du jour 07
        const rightEquationResults = this.findRightEquations();
        return rightEquationResults.reduce((total, result) => total + result, 0);
    }

    public async resultStar2(): Promise<number> {

        await this.initializeList();

        // Implémentation pour la deuxième étoile du jour 07
        const rightEquationResults = this.findRightEquations(true);
        return rightEquationResults.reduce((total, result) => total + result, 0);
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

