import type {ViewInterface} from "./ViewInterface";
import type {SlideComponentInterface} from "../Model/Interface/SlideComponentInterface";
import {Frame} from "../../Common/Common";
import {Rectangle} from "../Model/Entity/Rectangle";
import {AbstractShape} from "../Model/Entity/AbstractShape";
import {Ellipse} from "../Model/Entity/Ellipse";
import {Triangle} from "../Model/Entity/Triangle";
import {Image} from "../Model/Entity/Image";

class SlideView implements ViewInterface {
    private WIDTH = 1000;
    private HEIGHT = 500;

    private canvas: HTMLCanvasElement;
    private context: CanvasRenderingContext2D;
    private items = new Map<string, SlideComponentInterface>();

    public constructor(canvasId: string) {
        const element = document.getElementById(canvasId);
        if (!element || !(element instanceof HTMLCanvasElement)) {
            throw new Error(`Canvas element with id "${canvasId}" not found`);
        }
        this.canvas = element;
        this.canvas.width = this.WIDTH;
        this.canvas.height = this.HEIGHT;

        const ctx = this.canvas.getContext('2d');
        if (!ctx) {
            throw new Error('Failed to get 2d context');
        }
        this.context = ctx;
    }

    public renderObjects(objects: SlideComponentInterface[]) {
        objects.forEach((object) => {
            if (object instanceof AbstractShape) {
                this.context.fillStyle = object.getColor().hex;
            }
            if (object instanceof Rectangle) {
                this.drawRect(object);
            }
            if (object instanceof Ellipse) {
                this.drawEllipse(object);
            }
            if (object instanceof Triangle) {
                this.drawTriangle(object);
            }
            if (object instanceof Image) {
                this.drawImage(object);
            }
        });
    }

    public onObjectClick(callback: (objectId: string) => void): void {
        this.canvas.addEventListener('click', (event) => {
            const objectId = this.findShapeOnCoords(event.clientX, event.clientY);

            console.log('Click');

            if (objectId) {
                callback(objectId);
            }
        });
    }

    public onMouseMove(callback: (objectId: string) => void): void {
        throw new Error("Method not implemented.");
    }

    public getDefaultFrame(): Frame {
        const defaultWidth = 200;
        const defaultHeight = 100;

        return new Frame(
            this.canvas.width / 2 - defaultWidth / 2,
            this.canvas.height / 2 - defaultHeight / 2,
            this.canvas.width / 2 + defaultWidth / 2,
            this.canvas.height / 2 + defaultHeight / 2,
        );
    }

    private drawRect(rectangle: Rectangle): void {
        this.context.fillRect(
            rectangle.getFrame().getTopLeft().x,
            rectangle.getFrame().getTopLeft().y,
            rectangle.getFrame().getWidth(),
            rectangle.getFrame().getHeight(),
        );
    }

    private drawEllipse(ellipse: Ellipse): void {
        this.context.beginPath();
        this.context.ellipse(
            ellipse.getCenter().x,
            ellipse.getCenter().y,
            ellipse.getRadiusX(),
            ellipse.getRadiusY(),
            0, 0,
            2 * Math.PI,
        );
        this.context.fill();
    }

    private drawTriangle(triangle: Triangle): void {
        this.context.beginPath();
        triangle.getVertices().forEach((point, i) => {
            if (i === 0) {
                this.context.moveTo(point.x, point.y);
            } else {
                this.context.lineTo(point.x, point.y);
            }
        });
        this.context.closePath();
        this.context.fill();
    }

    private async drawImage(image: Image): Promise<void> {
        try {
            const img = await this.loadImage(image.getImgPath());

            this.context.drawImage(img, 100, 100);
            this.context.drawImage(img, 200, 200, 150, 100);

            this.context.drawImage(
                img,
                image.getFrame().getTopLeft().x,
                image.getFrame().getTopLeft().y,
                image.getFrame().getWidth(),
                image.getFrame().getHeight(),
            );
        } catch (error) {
            console.error('Error loading image:', error);
        }
    }

    private async loadImage(url: string): Promise<HTMLImageElement> {
        return new Promise((resolve, reject) => {
            const img = new window.Image();
            img.crossOrigin = 'anonymous';

            img.onload = () => resolve(img);
            img.onerror = (error) => reject(new Error(`Failed to load image: ${url}`));

            img.src = url;
        });
    }

    private findShapeOnCoords(x: number, y: number): string {
        return '';
    }

}

export {
    SlideView,
};
