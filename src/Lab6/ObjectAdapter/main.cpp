#include "ModernGraphicsLib.h"
#include "RendererToCanvasAdapter.h"
#include "ShapeDrawingLib.h"

namespace app
{
namespace sdl = shape_drawing_lib;
namespace mgl = modern_graphics_lib;

void PaintPicture(const sdl::CCanvasPainter& painter)
{
	const sdl::CTriangle triangle(
		{ 10, 15 },
		{ 100, 200 },
		{ 150, 250 }
		);
	const sdl::CRectangle rectangle({ 30, 40 },18, 24);

	painter.Draw(triangle);
	painter.Draw(rectangle);
}

void PaintPictureOnCanvas()
{
	graphics_lib::CCanvas simpleCanvas;
	const sdl::CCanvasPainter painter(simpleCanvas);
	PaintPicture(painter);
}

void PaintPictureOnModernGraphicsRenderer()
{
	mgl::CModernGraphicsRenderer renderer(std::cout);

	RendererToCanvasAdapter canvasAdapter(renderer);
	const sdl::CCanvasPainter painter(canvasAdapter);
	PaintPicture(painter);
}
} // namespace app


int main()
{
	std::cout << "Should we use new API (y)?" << std::endl;
	std::string userInput;
	if (getline(std::cin, userInput) &&
		(userInput == "y" || userInput == "Y"))
	{
		app::PaintPictureOnModernGraphicsRenderer();
	}
	else
	{
		app::PaintPictureOnCanvas();
	}
	return 0;
}