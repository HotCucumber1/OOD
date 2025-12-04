add_executable(TestTile TileTest.cpp)
add_executable(TestImageWithTile ImageWithTileTest.cpp)


target_link_libraries(TestTile PRIVATE Catch2::Catch2WithMain)
target_link_libraries(TestImageWithTile PRIVATE Catch2::Catch2WithMain)