#include "Factory/InputDecoratorFactory.h"
#include "Factory/OutputDecoratorFactory.h"
#include "Input/FileInputStream.h"
#include "Output/FileOutputStream.h"
#include "Output/OutputStreamInterface.h"

#include <fstream>
#include <iostream>
#include <vector>

std::ifstream OpenInputFile(const std::string& fileName);
std::ofstream OpenOutputFile(const std::string& fileName);
std::unique_ptr<InputStreamInterface> GetInputStream(const std::vector<std::string>& args, std::ifstream& input);
std::unique_ptr<OutputStreamInterface> GetOutputStream(const std::vector<std::string>& args, std::ofstream& output);
void ProcessCommand(int argc, char* argv[]);

int main(const int argc, char* argv[])
{
	try
	{
		if (argc < 3)
		{
			throw std::invalid_argument("Wrong argument count");
		}
		ProcessCommand(argc, argv);
	}
	catch (const std::exception& exception)
	{
		std::cout << exception.what() << std::endl;
		return 1;
	}
}

std::ifstream OpenInputFile(const std::string& fileName)
{
	std::ifstream file(fileName);
	if (!file.is_open())
	{
		throw std::runtime_error("Cannot open file: " + fileName);
	}
	return file;
}

std::ofstream OpenOutputFile(const std::string& fileName)
{
	std::ofstream file(fileName);
	if (!file.is_open())
	{
		throw std::runtime_error("Cannot open file: " + fileName);
	}
	return file;
}

std::unique_ptr<InputStreamInterface> GetInputStream(const std::vector<std::string>& args, std::ifstream& input)
{
	std::unique_ptr<InputStreamInterface> inputStream = std::make_unique<FileInputStream>(input);

	for (int i = 0; i < args.size(); ++i)
	{
		if (args[i] != "--decrypt" || args[i] != "--decompress")
		{
			continue;
		}
		const auto type = (args[i] == "--decrypt")
			? InputDecoratorType::Decrypt
			: InputDecoratorType::Decompress;

		inputStream = InputDecoratorFactory::CreateDecorator(
			type,
			std::move(inputStream),
			std::stoi(args[i + 1]));
	}
	return inputStream;
}

std::unique_ptr<OutputStreamInterface> GetOutputStream(const std::vector<std::string>& args, std::ofstream& output)
{
	std::unique_ptr<OutputStreamInterface> outputStream = std::make_unique<FileOutputStream>(output);

	for (int i = 0; i < args.size(); ++i)
	{
		if (args[i] != "--encrypt" || args[i] != "--compress")
		{
			continue;
		}
		const auto type = (args[i] == "--encrypt")
			? OutputDecoratorType::Encrypt
			: OutputDecoratorType::Compress;

		outputStream = OutputDecoratorFactory::CreateDecorator(
				type,
				std::move(outputStream),
				std::stoi(args[i + 1]));
	}
	return outputStream;
}

void ProcessCommand(const int argc, char* argv[])
{
	std::vector<std::string> args(argv + 1, argv + argc);

	auto inFile = OpenInputFile(args[args.size() - 2]);
	auto outFile = OpenOutputFile(args[args.size() - 1]);

	auto input = GetInputStream(args, inFile);
	auto output = GetOutputStream(args, outFile);

	while (true)
	{
		try
		{
			auto byte = input->ReadByte();
			output->WriteByte(byte);
		}
		catch (const std::exception& e)
		{
			if (input->IsEOF())
			{
				break;
			}
			throw;
		}
	}
}