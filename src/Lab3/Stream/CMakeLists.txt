configure_file(
        ${CMAKE_CURRENT_SOURCE_DIR}/input.dat
        ${CMAKE_CURRENT_BINARY_DIR}/input.dat
        COPYONLY
)

add_executable(Stream main.cpp
        Input/FileInputStream.cpp
        Input/DecryptDecorator.cpp
        Output/FileOutputStream.cpp
        Output/EncryptDecorator.cpp
        Cipher/Cipher.cpp)
