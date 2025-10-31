#pragma once
#include "../GraphicsLib.h"
#include "../ModernGraphicsLib.h"

class RendererToCanvasAdapter final
	: public modern_graphics_lib::CModernGraphicsRenderer
	, public graphics_lib::ICanvas
{
public:
	explicit RendererToCanvasAdapter(std::ostream& strm)
		: CModernGraphicsRenderer(strm)
		, m_lastPoint({ 0, 0 })
	{
		BeginDraw();
	}

	void MoveTo(int x, int y) override
	{
		m_lastPoint = { x, y };
	}

	void LineTo(int x, int y) override
	{
		DrawLine(
			m_lastPoint,
			{ x, y });

		m_lastPoint = { x, y };
	}

private:
	modern_graphics_lib::CPoint m_lastPoint;
};