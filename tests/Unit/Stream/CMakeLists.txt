add_executable(TestStream ../../../src/Lab3/Stream/Input/FileInputStream.cpp StreamTest.cpp)

target_link_libraries(TestStream PRIVATE Catch2::Catch2WithMain)