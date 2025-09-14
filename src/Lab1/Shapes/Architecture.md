## Фигуры

```mermaid
classDiagram
    class CanvasInterface {
        <<interface>>
        +moveTo(float x, float y) void
        +setColor(Color color) void
        +lineTo(float x, float y) void
        +drawEllipse(float cx, float cy, float rx, float ry) void
        +drawText(float left, float top, int fontSize, string text) void
    }

    class Color {
        -string colorHex 
        +getHex() string
    }

    class Rect {

    }

    class Point {

    }

    class Shape {
        -ShapeStrategyInterface shapeStrategy
        -Color color

        +Shape(ShapeStrategyInterface shapeStrategy)

        +draw(CanvasInterface canvas) void
        +move(float dx, float dy) void
        +getBounds() Rect
        +setBounds(Rect bounds) void
        +getColor() Color
        +setColor(Color color) void
        +setStrategy(ShapeStrategyInterface shapeStrategy) void
    }

    class Picture {
        -Map~string, Shape~ shapes

        +draw() void
        +move(float dx, float dy) void
        +storeShape(string id, Shape shape) void
        +deleteShape(string id) void
        +listShapes() Array~Shape~
        +findShape(string id) Shape
    }

    class ShapeStrategyInterface {
        +draw(CanvasInterface canvas, Color color) void
        +move(float dx, float dy) void
        +getBounds() Rect
        +setBounds(Rect bounds) void
    }

    class EllipseStrategy {
        -Point center
        -float xRadius
        -float yRadius

        +EllipseStrategy(float cx, float cy, float rx, float ry) void
        
        +draw(CanvasInterface canvas, Color color) void
        +getBounds() Rect
        +setBounds(Rect bounds) void
    }

    class RectangleStrategy {
        -Point topLeft
        -float width
        -float height

        +RectangleStrategy(float left, float top, float width, float height) void
        
        +draw(CanvasInterface canvas, Color color) void
        +getBounds() Rect
        +setBounds(Rect bounds) void
    }

    class TriangleStrategy {
        -Array~Point~ topLeft

        +TriangleStrategy(float x1, float y1, float x2, float y2, float x3, float y3) void
        
        +draw(CanvasInterface canvas, Color color) void
        +getBounds() Rect
        +setBounds(Rect bounds) void
    }

    class LineStrategy {
        -Point startPoint
        -Point endPoint

        +LineStrategy(float x1, float y1, float x2, float y2) void
        
        +draw(CanvasInterface canvas, Color color) void
        +getBounds() Rect
        +setBounds(Rect bounds) void
    }

    class TextStrategy {
        -Point startPoint
        -int fontSize
        -string text

        +TextStrategy(float x1, float y1, int fontSize, string text) void
        
        +draw(CanvasInterface canvas, Color color) void
        +getBounds() Rect
        +setBounds(Rect bounds) void
    }

    CanvasInterface ..> Color : use
    Shape ..> CanvasInterface : use
    Shape ..> Rect : use
    Picture *-- Shape

    Shape *-- ShapeStrategyInterface

    EllipseStrategy  ..|> ShapeStrategyInterface
    RectangleStrategy ..|> ShapeStrategyInterface
    TriangleStrategy ..|> ShapeStrategyInterface
    LineStrategy ..|> ShapeStrategyInterface
    TextStrategy ..|> ShapeStrategyInterface
# TODO убрать setBounds
```