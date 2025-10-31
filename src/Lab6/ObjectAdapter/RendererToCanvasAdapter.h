#pragma once

#include "GraphicsLib.h"
#include "ModernGraphicsLib.h"

class RendererToCanvasAdapter final : public graphics_lib::ICanvas
{
public:
	explicit RendererToCanvasAdapter(modern_graphics_lib::CModernGraphicsRenderer& renderer)
		: m_renderer(renderer)
		, m_lastPoint({ 0, 0 })
	{
		m_renderer.BeginDraw();
	}

	void MoveTo(const int x, const int y) override
	{
		m_lastPoint = { x, y };
	}

	void LineTo(int x, int y) override
	{
		m_renderer.DrawLine(
			m_lastPoint,
			{ x, y });

		m_lastPoint = { x, y };
	}

private:
	modern_graphics_lib::CModernGraphicsRenderer& m_renderer;
	modern_graphics_lib::CPoint m_lastPoint;
};