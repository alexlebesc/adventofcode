import * as fs from 'fs/promises';
import * as path from 'path';
import { DayResultInterface } from './day-result.interface';

class Day06 implements DayResultInterface {

    // Chemin du fichier d'input permettant de résoudre l'énigme du jour
    private filePath :string = path.join(__dirname, '../data/input_06.txt');

    static readonly TOP = 'TOP';
    static readonly BOTTOM = 'BOTTOM';
    static readonly LEFT = 'LEFT';
    static readonly RIGHT = 'RIGHT';

    private initialObstacles :Set<string>;
    private currentObstacles :Set<string>;
    private guardOnObstacleRegistry :Set<string>;
    private guardPositions :Set<string>;
    private guardCurrentPosition :number[] = [];
    private guardInitialPosition :number[] = [];
    private guardCurrentDirection :string = Day06.TOP;
    private guardInitialDirection :string = Day06.TOP;
    private maxY = 0;
    private maxX = 0;
    private guardIsLooping = false;

    constructor() {
        this.guardPositions = new Set<string>();
        this.guardOnObstacleRegistry = new Set<string>();
        this.initialObstacles = new Set<string>();
        this.currentObstacles = new Set<string>();
    }


    private async initializeList(): Promise<boolean> {
        if (this.maxY > 0 ) {
            return true;
        }

        return fs.readFile(this.filePath, 'utf8').then(data => {
            const lines :string[] = data.split('\n');
            this.maxY = lines.length;
            this.maxX = lines[0].length;

            lines.forEach((line, y) => {

                line.split('').forEach((gridCell, x) => {
                    if (gridCell === '.') {
                        return;
                    }

                    if (gridCell === '#') {
                        this.initialObstacles.add(y+','+x);
                    }

                    if (['^', '>', '<', 'v'].includes(gridCell)) {
                        this.guardInitialPosition = [y, x];
                        this.guardInitialDirection = '';
                        switch (gridCell) {
                            case '^': this.guardInitialDirection = Day06.TOP; break;
                            case 'v': this.guardInitialDirection = Day06.BOTTOM; break;
                            case '>': this.guardInitialDirection = Day06.RIGHT; break;
                            case '>': this.guardInitialDirection = Day06.LEFT; break;
                        }
                    }
                });
            });
            return true;
        });
    }

    private guardExit(guardPosition :number[]): boolean
    {
        const [guardY, guardX]  = guardPosition;
        return (
            guardY < 0
            || guardY >= this.maxY
            || guardX < 0
            || guardX >= this.maxX
        );
    }

    private guardIsOnObstacle(guardPosition :number[]) :boolean
    {
        const [y, x] = guardPosition;
        const obstacle = y+','+x+this.guardCurrentDirection;
        if (this.guardOnObstacleRegistry.has(obstacle)) {
            this.guardIsLooping = true;
            return true;
        }
        this.guardOnObstacleRegistry.add(y+','+x+this.guardCurrentDirection);
        return this.currentObstacles.has(y+','+x);
    }

    private guardTurnRight() {
        const direction = this.guardCurrentDirection;

        if(direction === Day06.TOP) {
            this.guardCurrentDirection = Day06.RIGHT;
        }
        if(direction === Day06.BOTTOM) {
            this.guardCurrentDirection = Day06.LEFT;
        }

        if(direction === Day06.LEFT) {
            this.guardCurrentDirection = Day06.TOP;
        }

        if(direction === Day06.RIGHT) {
            this.guardCurrentDirection = Day06.BOTTOM;
        }
    }

    private moveGuard(nbTurn = 0): boolean
    {
        let newPosition = this.guardCurrentPosition;
        let [y, x] = newPosition;

        if(this.guardCurrentDirection === Day06.TOP) {
            newPosition = [y - 1, x];
        }

        if(this.guardCurrentDirection === Day06.BOTTOM) {
            newPosition = [y + 1, x];
        }

        if(this.guardCurrentDirection === Day06.LEFT) {
            newPosition = [y, x - 1];
        }

        if(this.guardCurrentDirection === Day06.RIGHT) {
            newPosition = [y, x + 1];
        }

        if (newPosition === this.guardCurrentPosition) {
            throw 'infinite loop - guard cannot move';
        }

        if (this.guardIsOnObstacle(newPosition)) {
            if (this.guardIsLooping) {
                return false;
            }

            if (nbTurn >= 3) {
                throw 'stuck - all turn made';
            }
            this.guardTurnRight();
            return this.moveGuard(nbTurn + 1);
        }

        this.guardCurrentPosition = newPosition;

        return true;
    }

    private detectGuardPositions(obstacle :string | null = null)
    {
        this.guardCurrentDirection = this.guardInitialDirection;
        this.guardCurrentPosition = this.guardInitialPosition;
        this.guardPositions.clear();
        this.guardIsLooping = false;
        this.guardOnObstacleRegistry.clear();
        this.currentObstacles = new Set<string>(this.initialObstacles);

        if (obstacle) {
            this.currentObstacles.add(obstacle);
        }

        while(!this.guardExit(this.guardCurrentPosition) && !this.guardIsLooping ) {
            const [y, x] = this.guardCurrentPosition;
            this.guardPositions.add(y+','+x);
            this.moveGuard();
        }
    }

    public async resultStar1(): Promise<number> {

        // await this.initializeList();
        //
        // // Implémentation pour la première étoile du jour 06
        // this.detectGuardPositions();
        return this.guardPositions.size;
    }

    public async resultStar2(): Promise<number> {

        await this.initializeList();

        let  totalLooping = 0;

        // Implémentation pour la deuxième étoile du jour 06
        // faire un tableau de tous les initialObstacles possibles
        const possibleObstacles = new Set<string>();
        for (let y = 0; y < this.maxY; y++ ) {
            for (let x = 0; x < this.maxX; x++) {
                const possibleObstacle = y + ',' + x;
                if (!this.initialObstacles.has(possibleObstacle)) {
                    possibleObstacles.add(possibleObstacle);
                }
            }
        }

        possibleObstacles.forEach((possibleObstacle) => {
            this.detectGuardPositions(possibleObstacle);
            console.log(possibleObstacle, this.guardIsLooping);

            if (this.guardIsLooping) {
                totalLooping = totalLooping + 1;
            }
        });

        return totalLooping;
    }
}

(async () => {
    try {
        const day06:Day06 = new Day06();
        console.log('star1 :', await day06.resultStar1()) ;
        console.log('star2 :', await day06.resultStar2()) ;
    } catch (erreur) {
        console.error('Erreur :', erreur);
    }
})();

