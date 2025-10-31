```mertmaid
classDiagram 
    namespace shape_drawing_lib {
        class Point {
            + x: int
            + y: int
        }

        class ICanvasDrawable {
            <<interface>>
            + Draw(canvas: graphics_lib::ICanvas) void
        }

        class CTriangle {
            + CTriangle(p1: Point, p2: Point, p3: Point)
            + Draw(canvas: graphics_lib::ICanvas) void
        }

        class CRectangle {
            + CRectangle(leftTop: Point, width: int, height: int)
            + Draw(canvas: graphics_lib::ICanvas) void
        } 

        class CCanvasPainter {
            + CCanvasPainter(canvas: graphics_lib::ICanvas)
            + Draw(drawable: ICanvasDrawable) void
        }
    }

        namespace graphics_lib {
        class ICanvas {
            <<interface>>
            + MoveTo(x: int, y: int) void
            + LineTo(x: int, y: int) void
        }

        class CCanvas {
            + MoveTo(x: int, y: int) void
            + LineTo(x: int, y: int) void
        }
    }

    namespace modern_graphics_lib {
        class CPoint {
            + x: int
            + y: int
            CPoint(x: int, y: int)
        }

        class CModernGraphicsRenderer {
            - m_out: ostream
            - m_drawing: bool
            + CModernGraphicsRenderer(strm: ostream)
            + BeginDraw() void
            + EndDraw() void
            + DrawLine(start: CPoint, end: CPoint) void
        }
    }
    
    class RendererToCanvasAdapter {
        - m_renderer: CModernGraphicsRenderer
        - lastX: int
        - lastY: int

        + RendererToCanvasAdapter(renderer: CModernGraphicsRenderer)
        + MoveTo(x: int, y: int) void
        + LineTo(x: int, y: int) void
    }

    RendererToCanvasAdapter o-- CModernGraphicsRenderer
    RendererToCanvasAdapter *-- CPoint

    CCanvas ..|> ICanvas
    RendererToCanvasAdapter ..|> ICanvas
    
    CTriangle ..|> ICanvasDrawable
    CRectangle ..|> ICanvasDrawable

    CModernGraphicsRenderer --> CPoint : use
    CTriangle --> Point : use
    CRectangle --> Point : use

    CCanvasPainter o-- ICanvas
    CCanvasPainter --> ICanvasDrawable : use
```