import {Ellipse} from "../../../src/Lab10/Slide/Editor/Model/Entity/Ellipse";

describe('Ellipse', () => {
    it('Create ellipse success', () => {
        const ellipse = new Ellipse(
            {x: 10, y: 10},
            10,
            10,
            {hex: '#AAAAAA'},
        );

        expect(ellipse.getColor().hex).toEqual('#AAAAAA');
        expect(ellipse.getFrame().getTopLeft()).toEqual({x: 0, y: 0})
        expect(ellipse.getFrame().getBottomRight()).toEqual({x: 20, y: 20})
        expect(ellipse.getFrame().getWidth()).toEqual(20);
        expect(ellipse.getGroup()).toBeNull();
    });

    it('Change ellipse position success', () => {
        const ellipse = new Ellipse(
            {x: 10, y: 10},
            10,
            10,
            {hex: '#AAAAAA'},
        );

        expect(ellipse.getFrame().getTopLeft()).toEqual({x: 0, y: 0})
        expect(ellipse.getFrame().getBottomRight()).toEqual({x: 20, y: 20})

        ellipse.setPosition(10, 20);

        expect(ellipse.getFrame().getTopLeft()).toEqual({x: 10, y: 20})
        expect(ellipse.getFrame().getBottomRight()).toEqual({x: 30, y: 40})
        expect(ellipse.getFrame().getWidth()).toEqual(20);
    });
});
